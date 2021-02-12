<h1 align="center">Customer Visit Management (CVM)</h1>

<div align="center">
  <strong>
      💪 Laravel <code>backend</code>
      Vue.js <code>frontend</code> 💪
  </strong>
</div>
<div align="center">
  A web application that delivers the experience of
   visit reservation & management.
</div>

<div align="center">
  <h3>
    <a href="https://customer-visit-management.herokuapp.com">
      Live Demo
    </a>
    <span> | </span>
    <a href="https://github.com/Amirh0sseinHZ/CVM">
      Repo
    </a>
    <span> | </span>
    <a href="https://www.nfq.lt/">
      NFQ
    </a>
    <span> | </span>
    <a href="mailto:amirziaee12@gmail.com">
      Contact Me
    </a>
  </h3>
</div>

<div align="center">
  <sub>
      Built with ❤︎ by
      <a href="https://github.com/Amirh0sseinHZ">Amirhossein Ziaei</a>
      for the NFQ's challenge.
  </sub>
</div>

## Table of Contents
- [Task](#task)
- [Solution](#solution)
- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
- [Credentials](#credentials)
- [Session Length](#session-length)
- [User Guide](#user-guide)
- [Troubleshooting](#troubleshooting)
- [Feedback](#feedback)

# Task
Screens with serial numbers can be seen in customer service departments (bank, outpatient clinic, post office, etc.).
The incoming customer prints out the number and the display shows the waiting line and the customer's place in it.
To avoid serial numbers printed on papers, a system is needed that could allow the customer to book a visit time using
a website. After booking the time of the visit, the customer could see the waiting line and their respected place in it.
The queue is displayed on the service department screens. The customer can see how much time he has left before the
meeting according to the reservation code.

## Solution
Customer Visit Management (CVM) uses various technologies at both the front-end and back-end to offer a reliable and smooth
experience. Laravel with the aid of Sanctum and Fortify power our APIs. On the other end, Vue.js welcomes our users.
We use Tailwind CSS for our styles. These are all shipped in one single application. How cool is that?!!

Although CVM is shipped with Vue.js for its front-end, this doesn’t mean you can’t have your own front-end implementation
and use the APIs we provide.


## Prerequisites
- PHP `7.3+`
- Node.js
- Composer
- Database (either one)
    - MySQL `5.6+`
    - PostgreSQL `9.4+`
    - SQLite `3.8.8+`
    - SQL Server `2017+`


# Getting Started
After making sure we've got all the [prerequisites](#prerequisites) installed on our machine, we'll continue by cloning the repository:
```bash
git clone https://github.com/Amirh0sseinHZ/CVM.git
cd CVM
```

We proceed by installing the composer and node dependencies, as well as compiling our assets:
```bash
composer install
npm install
npm run dev
```

Now, we need to make a copy of `.env.example` file and fill it in with our own environment variables. To do that:
```bash
cp .env.example .env

vim .env # you can use your prefered editor instead
```

The most important variables for now to set:
```
# Database Setup Config
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Application URLs
SPA_URL=
MIX_API_URL=
SANCTUM_STATEFUL_DOMAINS=
```

- `SPA_URL` must match the URL that your front-end lives on.
- `MIX_API_URL` must match the URL that your back-end APIs (Laravel application) are being served.
- `SANCTUM_STATEFUL_DOMAINS` must contain all the allowed domains to pass CORS.
[Learn more](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS)

Moving on to the next step, we need to generate our app key via running the following artisan command:
```bash
php artisan key:generate
```

Now it's time to migrate our database:
```bash
php artisan migrate:fresh --seed  
```
- `seed` flag will fill our tables with some dummy data to work with

After a successful migration, you may ask Artisan to serve your application:
```bash
php artisan serve
```

In addition, you can run `npm run watch` to watch and compile the assets and provide you with browser-sync.


## Credentials
If you used the `seed` flag while migrating the database during the previous stage, 3 specialist accounts would be
created for you. The credentials are as follows:
```
spec1@nfq.lt:123456
spec2@nfq.lt:123456
spec3@nfq.lt:123456
```
You may use them to log in to our [Live Demo][demo] as well.

## Session Length
`SESSION_LENGTH` helps CVM to calculate the approximate waiting time in a queue. By default, it is set to 1200 seconds. 
You can find and modify this constant variable at [App/Models/Reservation](/App/Models/Reservation.php)
```php
...

/**
 * The length of an average session in seconds
 *
 * @var int
 */
public const SESSION_LENGTH = 1200;

...
````


# User Guide
CVM is designed to serve two types of users: _customers_ and _specialists_. Therefore, this user guide is divided into
two sections to address the needs of each role specifically.

### Customers
As a customer, the following actions are available to you:
- [[#]](#book-reservation) Book a reservation.
- [[#]](#check-status) Check the status of a reservation
- [[#]](#place-in-queue) See your place in the queue
- [[#]](#cancel-reservation) Cancel your reservation while still being at the waiting stage
- [[#]](#estimated-waiting-time) Get estimated waiting time

### Specialists
As a registered specialist, the following actions are available to you:
- [[#]](#service-department-screen) Check the Service Department Screen (SDS) where you can see all the active sessions and upcoming reservations of all
the specialists.
- [[#]](#my-customers) See all the customers who have booked you and are waiting in the queue
- [[#]](#accept-customer-reservation) Accept and start to give service to any reservation you want to disregard their position in the queue
(unless you have an active session at the moment)
- [[#]](#cancel-customer-reservation) Cancel any of your reservations
- [[#]](#end-session) End a session

## Detailed Guide
#### **Book Reservation**
To book a new reservation, visit the home page of the website. There you can see a link under the search bar, saying
_or book a new reservation now_! By clicking on the link, you will be redirected to a new page where you see a list of
specialists available. Check your preferred specialist and press on _Book an Appointment_. If your reservation is
successful, you'll be redirected to a new page where you can see your place in the queue. It's marked as blue.

The colors under specialists' names indicate how busy they are:
- **Green:** free or almost free
- **Yellow:**  slightly busy
- **Orange:** busy
- **Red:** extremely busy

#### **Check Status**
To check the status of your reservation, navigate to the home page. The search bar in the middle of the page is where
you should enter the reservation code you were issued with. If it's entered correctly, the search bar turns to green
,and the result will be displayed. Click on it and you will be able to see detailed information of your reservation.

#### **Place in Queue**
If your reservation is in the `waiting` stage, you can check your place in the queue by searching its code on our home page.
After our search bar finds your reservation, simply click on it. This page refreshes every 5 seconds behind the scene, so
you do not need to refresh it manually.

#### **Cancel Reservation**
To cancel your reservation, again it needs to be at the `waiting` stage. Follow the instruction for
**Place in Queue**, and then at the end of the page you will see a cancel button. Please keep in mind, this action can't
be reverted.

#### **Estimated Waiting Time**
Estimated waiting time can be checked on the same page as the queue. To check how much time is left till you
get to meet your specialist, please follow [Place in Queue](#place-in-queue). The estimated time is displayed at the top
of the queue. Please note that this estimation is updated constantly. If you find it stuck, this means that your
specialist is idle.

#### **Service Department Screen**
You can find this page under the title __SDS__ on the navigation bar. Here you can see all the active sessions of all
the specialists as well as 5 upcoming reservations with respect to the queues. Auto-update is also enabled on this page.

#### **My Customers**
Please first make sure you are logged in to your account. Then navigate to the tab **Dashboard**. Here you can all of your
incoming reservations (if any) and active session (if exists). The reservations placed at top of the list are the ones that
should be served first, however, nothing stops you from disrespecting the queue. This page is also updated automatically
, and no manual refresh is needed from your side.

#### **Accept Customer Reservation**
On your dashboard, you can accept your customers' reservations by simply clicking on the **accept** green button in
front of their codes. There can be only one active session at a time.

#### **Cancel Customer Reservation**
The cancel operation can be done similarly to accept. There is no limitation on this feature.

#### **End Session**
When you accept a reservation, it's your responsibility to mark the end of it as well. To do that, navigate to
your dashboard. If there's any active session, it's marked at the top under the **Active Session** title. Pressing on
the red button in front of its code marks the session as served.

# Troubleshooting
- __401 Unauthorized__: `SANCTUM_STATEFUL_DOMAINS` is not set properly.

## Feedback
I'd love to hear your opinions and ideas. Feel free to reach via [email](mailto:amirziaee12@gmail.com).



[demo]: https://customer-visit-management.herokuapp.com

