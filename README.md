#### LiveElex
## Live election results using Google Docs

Create and manage live election results using Google Docs as the backend CMS for live, simultaneous updating. If you do not have a server available, you can publish the results entirely in Google and link to them from your site. If you have a server with PHP, you can use the display.php script to iframe or include in your site.

##V.6

This version is usable, though nowhere near feature-complete. It's being released so that newsrooms can (hopefully) use it for the 2014 primaries. It's a little rough around the edges, but if you follow the directions you can make it work. This version is a little bit difficult to setup, but it will get easier.

##Setup

First, go to this [Google Spreadsheet](https://docs.google.com/spreadsheets/d/1k-fcpYg_YlLx_DrXh0vMdkxN0xOBuj_mVxwTVCj5zpY/edit?usp=sharing). You MUST be using an account that allows you to publish to the web (some corporate accounts do not allow this). When you open it, go to File > Create a copy. This is yours to play with.

There are two example races already in the file.  DO NOT alter the structure of the races. If you do, they will break.

**The top two lines are basically administrative options.** The "slug" field needs to be 1) unique to the page, 2) not start with a number, and 3) not use special characters or spaces. I would suggest something like "senate" or "house112." These will not be shown to the public.

The "Race" field is the race name that will be displayed to the public. You can be as specific ("U.S. Senator — Democrat") or generic ("House") as you'd like.  "Candidates" refers to the number of candidates who are running. "Positions" refers to how many people are advancing/winning (For example, if it's a "top two" primary, you'd put in "2." This will most often just be "1"). Type and PctCount should be left as-is.

On the next line down, the "Counted" and "Total" fields refer to the number of precincts or polling stations that are being reported. If you know the total number of precincts (and your county/state gives you how many they've counted), put the total under "Total." As they count the precincts, add them under "Counted." The front end will display the percentage counted. If Total is 0, it will not display anything.

**The candidates part is the section of the form you can change, but do so carefully.** Use the prescribed party fields (as they're programmed on the front-end to display the proper colors; unfortunately, it's a limited list right now but I plan to add custom colors down the road). Your options are (D)emocrat, (R)epublican, (G)reen, (L)ibertarian, (I)ndendent or (O)ther.

If you need to add or remove a row, do so after the second candidate position (so you don't mess with the "Counted" and  "Total" fields). Make sure you remove and add rows by right-clicking the row number on the left and using "Delete Row" or "Insert 1 Below," respectively. 

**Always leave a blank row between the races.** Otherwise it'll break.

##Publishing##

**You need to do this part regardless of which option (PHP or Google) you choose.** When your races are set up, copy your Spreadsheet ID (it's the part of the URL after "https://docs.google.com/spreadsheets/[letter]/" and before "/edit" — in the master file, "https://docs.google.com/spreadsheets/d/1k-fcpYg_YlLx_DrXh0vMdkxN0xOBuj_mVxwTVCj5zpY/edit#gid=0", it's `1k-fcpYg_YlLx_DrXh0vMdkxN0xOBuj_mVxwTVCj5zpY`). 

Now go to Tools > Script Editor. You should see the script already set up for you. All you need to do is find the place where it says "Sheet ID goes here" under function doGet(request). Paste your sheet ID INSIDE the quotes. Now, go up to Publish > Deploy as web app. In the window that pops up, you'll need to enter something in the "Project version" field (I'd just use "launch" or something) and hit "Save new version." Leave "Execute the app" as "me" (your email address), but change "Who has access to this app" from "Only myself" to "Anyone (even anonymous)." Then hit "Deploy." Make sure you copy the "Current web app URL."

You may need to run the application once in order to authorize Google Apps Script. In the toolbar, click "Select function" and select `doGet()`. Then hit the play button to the left. It will ask you for authorization to run. Hit "Continue" and allow the app to access your Spreadsheets (Don't worry, it can only access the sheet ID you entered into the script).  

**If you're just using Google, you're basically done.** The web app URL just needs to be linked from your CMS. As Google Scripts cannot (currently) being included as iframes on external sites, there's not much more that can be done.

**If you're using the PHP page, you're also almost done.** Open up display.php and change the $url variable at the top to your web app URL. You can then iframe this page to include it directly in your site or use the code to display the results (if you have a PHP-driven website). 

##Troubleshooting

**General tips**
- Only use "Delete Row" and "Insert 1 Below." Otherwise the vote counting will get thrown off
- Make sure you have the right number of candidates in "Candidates"
- Publish as web app, allow "Anyone (even anonymous)" to access it

**Questions**
Email dan.herman@gmail.com with the subject line "GElex."

##Planned Milestones

√	v.1 — Develop schema for storage in Docs  
√	v.2 - Connect to Docs  
√	v.3 - Display existing race on page  
√	v.4 - Styling for races  
√	v.5 - Create Admin area   
√	v.6 - Serve everything from Google Apps/Script  
	v.7 - Create a race from the Admin area  
	v.8 - Manage races from the Admin area  
	v.9 - Domain-specific races  
	v.1.0 - Polishing/Ship  
	v1.1 - Custom parties  
	v1.2 - Embed specific races  
	v1.3 - Different displays/race types