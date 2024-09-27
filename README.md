# Responsive Online Courses With Admin Panel

## Languages: Pure HTML, CSS, PHP, JavaScript.

![Home page](images/homePage.jpg)
*Home Page*

![Mobile View](images/700pxView.jpg)
*Mobile View*

![Login](images/loginInterface.jpg)
*Login Popup*

## SPECIAL FEATURE: Notification system between two folders 

*Please note that this project using basic and pure technique, so this idea is maybe not that good to implement in real project !*

> Idea: When we send request to another folder, store the first value to "Notification", and check if the second value is smaller than the first value, then notify it and update it, just like two pointer.

Steps:

1. Create a table named "Notification", store 4 values like FirstCount, SecondCount, ThirdCount, FourthCount.

2. Update table values on user submit.

3. Implement JavaScript function to fetch and announce a message. Then using `setTimeout()`, example:
   
`setTimeout(yourfunction, time in second);`