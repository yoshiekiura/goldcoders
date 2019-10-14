Paymaster Portal

-   return payments count when click load specific user payments table
-   Paymaster Edit Specific Page Copy Members Edit remove some field such as paymaster - restrict paymaster not to edit password, email , account type - only allow paymaster to edit active - paymaster can create new user - paymaster cannot delete a user that has a payment status - remove filter on paymaster since paymaster can only view all his members
    Referral Page
-   add create new referral page which will just send an email link /note only admin can create a user
-   add a button on paymaster portal to view all the document uploaded
-   add a button for paymaster to see kyc

Connect Api ( paymaster )

-   Requirement Ctrader Login
-   Broker
-   Bank Accounts
    When a paymaster connect api
-   this will load all their trading accounts
-   paymaster then can add user to each of their live trading account
-   members can then view the trading history of that trading account

Referral by Email

-   User Registration Page / Private Invitation Email - user email, user name - default email template for invitation - custom email invitation
-   User will fill up all details when they click email link
-   Sponsor is already link, Paymaster is already link
-   user fills this field - fname,mname,lname,suffix,email,username,mobile,dob, password, addresses

User Process When Created to Referral Email
When a Admin/Paymaster send an invitation link
A user click the email link
then it will create a new User
then send an email with custom random password
User can then use their email to log in with email and pass

-   Add a middleware for user not to show other options unless they are active
-   being active means they filled up their info and passed KYC
-   they have download the proper documents and signed it and upload it
-   then after that user can view payment
-   add a payout gateway
-   and view request payout
-   on their dashbord they can see if their subscriptionn is active
-   the trading account history

-   Gateway
-   when you create a forpayout gateway that will be visible as accepted gateway for your members
-   So that when the user will add their payout details, this will prepopulate the field
    of type, when user pick bank_deposit it will all load all the bank_deposit type of specific paymaster

Member on making a Payment

-   User will create a new Gateway with type being pre-populated with ['bank_deposit','remittance','paypal','cash_on_hand'], gateway is active by default
-   User can only add the value fields the field name will be readonly
-   Member will just filled up only Amount
-   and the payment gateway they want to be paid
-   once they submit it the paymaster/admin can view the payments
-   paymaster can download all non paid payments in bulk in zip file or excel for easy viewing
-   paymaster can select the type of download ['bank_deposit'] etc.

*   Connect Api
*   Can Be Used to give permission to all trading account
*   If the paymaster click this again they can , modify the trading account they want to have
*   they can add or delete
*   If the User remove the Trading account ID, on select

    -   it will affect the database


    Add a Refersh token button
