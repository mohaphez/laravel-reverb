<template>
  <div class="min-h-screen bg-white p-6">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Basic toolbar -->
        <div class="flex gap-4 mb-4 border-b pb-4">
          <button @click="formatText('bold')" 
                  class="p-2 hover:bg-gray-100 rounded" 
                  :class="{ 'bg-gray-200': isFormatActive('bold') }">
            <i class="fas fa-bold"></i>
          </button>
          <button @click="formatText('italic')" 
                  class="p-2 hover:bg-gray-100 rounded"
                  :class="{ 'bg-gray-200': isFormatActive('italic') }">
            <i class="fas fa-italic"></i>
          </button>
          <button @click="formatText('underline')" 
                  class="p-2 hover:bg-gray-100 rounded"
                  :class="{ 'bg-gray-200': isFormatActive('underline') }">
            <i class="fas fa-underline"></i>
          </button>
        </div>

        <!-- Editor area -->
        <div ref="editor" 
             contenteditable="true" 
             class="editor-content min-h-[500px] p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
             @input="handleInput"
             @keydown="saveCaretPosition"
             @keyup="handleKeyUp"
             @mouseup="saveCaretPosition"
             @focus="saveCaretPosition"></div>
      </div>
    </div>
  </div>
</template>

<script>
let typingTimer;
const TYPING_TIMEOUT = 1000; // 1 second

export default {
  name: 'DocumentEditor',
  props: {
    documentId: {
      type: String,
      required: true
    },
    initialContent: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      content: this.initialContent,
      lastSentContent: this.initialContent,
      isTyping: false,
      selection: null
    }
  },
  mounted() {
    // Set initial content directly
    this.$refs.editor.innerHTML = this.initialContent;

    Echo.private(`document.${this.documentId}`)
      .listen('DocumentUpdated', (e) => {
        if (e.content !== this.lastSentContent) {
          this.updateContent(e.content);
        }
      });
  },
  methods: {
    formatText(command) {
      document.execCommand(command, false, null);
      this.saveContent();
    },
    isFormatActive(command) {
      return document.queryCommandState(command);
    },
    saveCaretPosition() {
      this.selection = this.getCaretPosition();
    },
    getCaretPosition() {
      const selection = window.getSelection();
      if (selection.rangeCount === 0) return null;
      
      const range = selection.getRangeAt(0);
      const preSelectionRange = range.cloneRange();
      preSelectionRange.selectNodeContents(this.$refs.editor);
      preSelectionRange.setEnd(range.startContainer, range.startOffset);
      
      return {
        startContainer: range.startContainer,
        startOffset: range.startOffset,
        endContainer: range.endContainer,
        endOffset: range.endOffset
      };
    },
    restoreCaretPosition() {
      if (!this.selection) return;
      
      const selection = window.getSelection();
      const range = document.createRange();
      
      try {
        range.setStart(this.selection.startContainer, this.selection.startOffset);
        range.setEnd(this.selection.endContainer, this.selection.endOffset);
        selection.removeAllRanges();
        selection.addRange(range);
      } catch (e) {
        console.warn('Could not restore caret position:', e);
      }
    },
    handleInput() {
      this.saveContent();
    },
    saveContent() {
  
      this.content = this.$refs.editor.innerHTML;
      this.isTyping = true;
      this.debounceSendUpdate();
    },
    handleKeyUp() {
      this.isTyping = true;
      this.debounceSendUpdate();
    },
    debounceSendUpdate() {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(() => {
        this.sendUpdate();
      }, TYPING_TIMEOUT);
    },
    async sendUpdate() {
      if (this.content !== this.lastSentContent) {
        try {
          Echo.private(`document.${this.documentId}`)
            .whisper('typing', {
              content: this.content
            });
          
          this.lastSentContent = this.content;
        } catch (error) {
          console.error('Error saving document:', error);
        }
      }
      this.isTyping = false;
    },
    updateContent(newContent) {
      if (!this.isTyping) {
        this.saveCaretPosition();
        
        // Update the element's content directly
        this.$refs.editor.innerHTML = newContent;
        this.content = newContent;
        
        this.$nextTick(() => {
          this.restoreCaretPosition();
        });
      }
    }
  }
}
</script>

<style scoped>
[contenteditable]:empty:before {
  content: 'Start typing here...';
  color: #9ca3af;
  cursor: text;
}

.editor-content {
  text-align: left;
  direction: ltr;
  white-space: pre-wrap;
  word-wrap: break-word;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
</style> 