<h1>Overview</h1>
<h3> Stream Lab Assignment</h3>

**Installation Steps**


<ul>
    <li> Clone repository</li>
    <li> Rename .env.example to .env</li>
    <li> Run Composer Install</li>
    <li> Run npm install</li>
    <li> npm run dev</li>
    <li> npm run migrate</li>
    <li>Please link your PayPal sandbox to your braintree account https://developer.paypal.com/braintree/docs/guides/paypal/testing-go-live#linked-paypal</li>
    <li> run php artisan db:seed (will create test user and plans)</li>
    <li>You can also register for your own user</li>
    <li> Replace DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env</li>
    <li> In .env file Configure BRAIN_TREE... variables from your braintree account </li>
</ul>

_Testing Instructions_
<ul>
    <li>Login or Register</li>
    <li>Select Desired package</li>
    <li>Select Payment Method</li>
    <li>Get success Message</li>
    <li>Login to Braintree</li>
    <li>Check Customer Created, Check Plans created, Check Transaction created and payment method linked and check subscription created</li>
</ul>
