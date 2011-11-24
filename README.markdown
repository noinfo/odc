# Welcome to ODC: On Demand CMS version 0.5
                                                
_It is meant to be a quick, simple and highly adaptable solution to add 
editable regions to existing webpages._
                        
This version makes use of nicedit ([www.nicedit.com](www.nicedit.com)) to provide a more user-friendly way
to edit content. Most of ODC was written by Fabian Meyer ([www.noinfo.de]( www.noinfo.de )) on the 5th and 
6th of december 2010. The markdown integration was added in september of 2011 using 
php-markdown by Michel Fortin ([http://michelf.com/](http://michelf.com/)). 
        
__Disclaimer: This software is provided as-is and I will not be held responsible for any damages that come from using this software.__
        
This software is written and meant to be in the back-end of a webpage, ideally behind a
.htaccess to restrict access only to authorized parties. As such no sanitation of strings 
has been made when connecting to the database as it is assumed that only authorized persons 
can access the back-end (and that those won't try SQL-injection attacks, as they could 
simply delete all content using the edit functions).

