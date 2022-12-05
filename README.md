# Bowie Backend
Bowie is a simple casino lobby. I've created this to learn more about frontend and to fill my portfolio with code, I will be working on it while bored finding job/next challenge.

## Development
This is an app I've developed from scratch utilizing Lumen (backend), React/NextJS (frontend), Docker/Kubernetes (container).

This repository contains the backend. For frontend check other repository. Get app run in 1 command on Docker.

## Demo
You could check if [bowie.casinoman.app](https://bowie.casinoman.app) is up (vercel.com hosted frontend connected to this backend code in middleware), to give impression:

### screen recordings:
- [bowie app - three in a row game & theme selection](https://www.youtube.com/watch?v=6ICsFWHlw3A)
- [bowie app - rock paper scissors game](https://www.youtube.com/watch?v=yIDjlCI9L0c)

### login/register screen
![pre auth screen login/register](https://raw.githubusercontent.com/ryan-west-casino/bowie-media/main/bowie-preauth-guest.png)

## Casino Features
Has 2 inhouse games which really are filler games, external game is an example available (but obviously you would need to build in your api).

By default you start with 100$ balance, you can change this in `App\Http\Controllers\AuthController`.

## Frontend
Frontend is seperately run and is not in this repository, you can run this in [vercel.app](vercel.app), check frontend repository for this.

## Setup backend: development/staging
The oficial php image from Google Cloud Platform is updated once in a lifetime so I decided to manage my own php images.

- Set the .env variables, see .env.example that is already configured to point to pgsql and redis services
- Run the container with `docker-compose up`.
Alternatively, if you have an older laptop, try running remotely with
[Blimp](https://kelda.io/blimp).
- Enter into app container with `docker exec -it default-structure-app bash`
- Run php composer, something like `composer install --no-cache --no-ansi -n -o`
- Run the migrations with `php artisan migrate:fresh`
- Run `php artisan key:generate` to generate secret hash
- Run `php artisan jwt:secret` to set JWT auth secret

And it's up and running, set public domain to this api on frontend :)

## Setup backend: production
See the contents of the `.k8s` folder :)

## Alternative Images
If you would turn this setup up for production and scale, you should probably be using alpine on most php images, you can find example in Dockerfile.alpine.

## Base Lumen API Features

- 2FA
- ACL
- Audit
- CORS
- Device authorization
- Etag
- Lumen (9x)
- Login
- Login history
- Multiple localizations, preconfigured with en_US and pt_BR
- Password reset
- Password must not be in one of the 4 million weak passwords
- PHPCS PSR2, phpinsights and sonarqube analysis
- Register
- Swoole
- Tests
- Transactional events: Listen to events and send notifications only if the transaction is commited
- uuid

## Database structure
<img width="100%" alt="Screen Shot 2019-05-26 at 17 55 32" src="https://user-images.githubusercontent.com/4256471/88346965-02551780-cd20-11ea-8b35-3d4f8568ad74.png">

## Routes
<img width="100%" alt="Screen Shot 2019-05-26 at 17 56 41" src="https://user-images.githubusercontent.com/4256471/88347112-56f89280-cd20-11ea-867e-b8b11d0ee256.png">
