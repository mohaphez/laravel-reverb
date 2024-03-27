# Exploring Real-Time Scenarios in Laravel with Reverb

With the recent integration of Reverb into the Laravel ecosystem, real-time features have become more accessible without the need for external services. In this project, I aim to explore various scenarios utilizing this capability.

### Scenarios Overview:

- **Live Location Sharing**: Enable real-time sharing of locations between drivers and passengers (client-to-client).
  - You can find the scenario description [here](https://medium.com/devops-dev/live-location-sharing-with-laravel-and-reverb-7c3b8c54bc0d).
      ![laravel-share-live-location](https://github.com/mohaphez/laravel-reverb/assets/20874565/d949f3e0-12a6-42a2-accf-bffeb377c57f)
- **Notification Broadcasting**: Trigger events and broadcast notifications to specific clients or presence channels.
   - You can find the scenario description [here](https://hessam-dev.medium.com/broadcast-notification-to-authorized-user-64dc05f7a427).
![notification](https://github.com/mohaphez/laravel-reverb/assets/20874565/95adb257-5719-42cd-b6e0-e260ade75a57)
- **Real-Time Currency Market Updates**: Broadcast real-time updates of currency market prices (coming soon).
- **Client-Side Data Persistence**: Receive and persist user-provided information on the socket platform in real-time (coming soon).

## Getting Started

Follow these steps to set up the project on your local environment:

### Prerequisites

Before you begin, make sure you have the following prerequisites installed on your system:

-   [Git](https://git-scm.com/)
-   [Composer](https://getcomposer.org/)
-   [Docker](https://www.docker.com/)
-   [Docker Compose](https://docs.docker.com/compose/)

### Installation

1. Clone the project from GitHub:

    ```bash
    git clone https://github.com/mohaphez/laravel-reverb.git
    cd laravel-reverb
    ```

2. Copy the `.env.example` file and rename it to `.env`:

    ```bash
    cp .env.example .env
    ```

3. Install the project dependencies using Composer:

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs --no-scripts
    ```

4. Start the development environment using Docker Sail:

    ```bash
    ./vendor/bin/sail up -d
    ```

5. Update the project dependencies using Composer (**Important**):

    ```bash
        ./vendor/bin/sail composer update
    ```

6. Restart Docker Sail:

    ```bash
        ./vendor/bin/sail down && ./vendor/bin/sail up
    ```

7. Generate an application key:

    ```bash
    ./vendor/bin/sail php artisan key:generate
    ```

8. Run migrations the database:

    ```bash
    ./vendor/bin/sail php artisan migrate
    ```

9. Run seed the database:

    ```bash
    ./vendor/bin/sail php artisan module:seed
    ```

10. Run reverb server:

    ```bash
    ./vendor/bin/sail php artisan reverb:start --debug
    ```

9. Run vite:

    ```bash
    ./vendor/bin/sail npm run mars:dev
    ```
### Accessing the Application

You can access the panel by opening your web browser and navigating to:

```
http://localhost/login
```

### Default Driver Credentials

-   **Username:** driver@example.com
-   **Password:** password

### Default Passenger Credentials

-   **Username:** passenger@example.com
-   **Password:** password
