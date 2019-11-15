Create Sub

-   Return config subtype key name as an array
-

-->Priority
--> create a table where we can save a plan type formatting
Fields

-   Name
-   paymaster_id
-   Events in CamelCase
-   type in pure text
-   duration
-   interval
-   interval_count
    // to polish this we need to draw how each plan type work
    so we can categorize what fields are same in all type
    // and what fields need to be added dynamically
    // specifi for each type define by using json type

-> fetch on server all the types or just read it from the class
WE need to Create a New table for Saving the Format
Of the Suscription Type
--> the one we have on subscription create will be this
--> Add a Way to Dynamically Add Events For Commission
--> The Event for Subscription End and Renew is automatically selected

--> Next
The Subscription Type Model That is Polymorph are the Models
Where in Specific User and Paymaster has it

Creating Subscription

User Populate the Fields The is Required across all plans

Choose a Plan

Fill up the Fields

Submit
// Save to Database

Redirect to Index for Authenticated Paymaster

// For Index If you Are Super Admin
// Show All Subscription Type
// Only Super Admin/ Admin can approved the Plan Type

Server Is Running a Cron That runs Every 5 mins

-   Responsible for Paying Commission
-   Turn Subscription Off
-   Renew Subscription
-   Pay Referral Commission
-   Pay Other Commission (matrix ie.)
-
