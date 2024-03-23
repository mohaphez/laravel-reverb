<?php

declare(strict_types=1);

namespace Modules\Support\Entities\Concerns;

trait AssetsHelper
{
    public function getAssets(?string $sectionPreference = null, ?string $typePreference = null, ?string $data = null): array|self
    {

        $jsonData = $this->settings ?? json_decode($data ?? 'null');
        $jsonData = is_string($jsonData) ? json_decode($jsonData) : (object) $jsonData;

        if(null === $jsonData || ! property_exists($jsonData, 'assets')) {
            return [];
        }

        $urls = collect($jsonData->assets)
            ->when($sectionPreference, function ($collection, $section) use ($typePreference) {
                return collect($collection->get($section, []))
                    ->when($typePreference, fn ($subCollection, $type) => collect($subCollection->get($type, []))->pluck('url')->filter(), fn ($subCollection) => $subCollection->flatMap(fn ($subSection) => collect($subSection)->pluck('url')->filter()));
            }, fn ($collection) => $collection->flatMap(fn ($section) => collect($section)->flatMap(fn ($subSection) => collect($subSection)->pluck('url')->filter())))
            ->filter();

        return $urls->toArray();
    }


    public function getAssetsTags(?string $sectionPreference = null, ?string $typePreference = null, ?string $data = null): array|self
    {

        $tags = [];
        $assets = $this->getAssets($sectionPreference, $typePreference, $data);

        foreach ($assets as $url) {
            $fileExtension = pathinfo($url, PATHINFO_EXTENSION);
            if ('css' === $fileExtension) {
                $tags[] = "<link rel=\"stylesheet\" href=\"{$url}\">";
            } elseif ('js' === $fileExtension) {
                $tags[] = "<script src=\"{$url}\"></script>";
            }
        }

        return $tags;
    }

}
