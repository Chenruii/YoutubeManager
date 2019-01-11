# YoutubeManager


ABOUT
YouTube Manager ​is a web platform where visitors can sign in or register and manage a Youtube videos linklist.A                                           connecteduseristheonlyonewhocanmanagehislistofcontents.TheplatformcanbemanagedbyanAdminona                                               specific webpage to manage all users (edit/delete), contents (edit/delete) and categories (edit/delete).  

TECH
As Visitor (Anonymous)  - I can see on the ​main webpage ​a list of all published Videos and Categories with a link to see the details of the Videos, a  link to see the autor profile and a category link to see all published Videos from a Category.  - I can ​register ​as an user with a​ mandatory email ​and​ password​, and ​optionally ​a ​firstname​, ​lastname​ and ​birthday​.  - I can ​log in​ with an ​email ​and​ ​a ​password​ and see the same error message if the email or the password is wrong.  - I can see all published Videos from a category    As User and only User (ROLE_USER)  - I can ​edit only ​my ​firstname​, ​lastname ​and ​birthday​.  - I can ​create a Video​. A Video contains a ​mandatory​ ​title, createdAt, published ​and ​url ​(the YouTube video url link) and  optionally ​a ​description and a Category​.  - I can ​see ​on a specific page my ​list ​of all Videos ​(published/unpublished)​.  - I can ​edit ​on a specific page one Video (of my collection) with its ​title​, ​url, description, published and category​.  - I can ​delete ​one of my Video from the list and from the Video specific page.    As Admin and only Admin (ROLE_ADMIN)  - I get the ​same features as ROLE_USER​.  - I can see on a page ​all Users​ ​details (including their Videos published/unpublished) in a list.  - I can see on a page​ all ​Categories details  - I can ​create ​a ​category ​with a mandatory ​title ​and ​optionally ​a ​description​.  - I can edit the content of any User, Video and Category.  - I can remove any User, Video and Category.    As Server Administrator  - I can see ​logs ​when an ​Video ​is ​created, updated ​or ​removed​. Log the ​User email​ ​who created the Video, the ​title ​and  the​ id​.  - An ​Event ​is propagated when a ​Video ​is ​created,​ ​updated ​or ​removed​. A ​Subscriber ​will ​write logs​.  - With a ​command​, I can ​create a User Admin​ (with both ROLE_USER and ROLE_ADMIN) using an ​email ​and a ​password​.  - With a ​command​, I can ​display the number of Video​ for an ​User ​with his ​email​.​ ​Display an error if the User does not  exists. 


NavB​ar ​: 
A navigation bar is basically a list of links button to help to User to navigate through pages of the website.

Assert that :  
- User ​email ​is ​unique​, a ​real email ​and ​not empty  
- User ​password ​is ​not empty  
- User ​birthday ​is a ​DateTime  
- Video ​title ​is min ​length = 5  
- Video ​url ​is a real ​URL

Notification (Symfony Flash Message) after
- An ​User/Video​ is created, updated or deleted 
- An ​User ​log in/log out. 


Nota Bene ​: Code must be hosted with ​GitHub ​or ​GitLab​. ​Comment your code!​ Even though it's not a complete feature. Extra  features or slight changes of the requirements are allowed and will be considered, please document them in the README.md  file.​The website aesthetic does not have to be perfect.​ The aim of this project is above all for you to manipulate the Symfony  framework, not to make the website fantastic. ​Use your common sense and knowledge to prioritise and good luck​.