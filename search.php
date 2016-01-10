<?php
require_once("../config.php");
$database = "if15_meritak";
$mysqli = new mysqli($servername, $username, $password, $database);
$button = $_GET ['submit'];
$search = $_GET ['search']; 
 
if(!$button)
echo "you didn't submit a keyword";
else
{
if(strlen($search)<=1)
echo "Search term too short";
else{
echo "You searched for <b>$search</b> <hr size='1'></br>";
mysql_connect("localhost","your mysql username","password");
mysql_select_db("your database name");
 
$search_exploded = explode (" ", $search);
 
foreach($search_exploded as $search_each)
{
$x++;
if($x==1)
$construct .="keywords LIKE '%$search_each%'";
else
$construct .="AND keywords LIKE '%$search_each%'";
 
}
 
$construct ="SELECT * FROM searchengine WHERE $construct";
$run = mysql_query($construct);
 
$foundnum = mysql_num_rows($run);
 
if ($foundnum==0)
echo "Sorry, there are no matching result for <b>$search</b>.</br></br>1. 
Try more general words. for example: If you want to search 'how to create a website'
then use general keyword like 'create' 'website'</br>2. Try different words with similar
 meaning</br>3. Please check your spelling";
else
{
echo "$foundnum results found !<p>";
 
while($runrows = mysql_fetch_assoc($run))
{
$title = $runrows ['title'];
$desc = $runrows ['description'];
$url = $runrows ['url'];
 
echo "
<a href='$url'><b>$title</b></a><br>
$desc<br>
<a href='$url'>$url</a><p>
";
 
}
}
 
}
}
 
?>
html>
  <head>
    <script src="https://www.google.com/jsapi"
        type="text/javascript"></script>
    <script type="text/javascript">
      google.load("search", "1");

      // Call this function when the page has been loaded
      function initialize() {
        var searchControl = new google.search.SearchControl();
        searchControl.addSearcher(new google.search.WebSearch());
        searchControl.addSearcher(new google.search.NewsSearch());
        searchControl.draw(document.getElementById("searchcontrol"));
      }
      google.setOnLoadCallback(initialize);
    </script>

  </head>
  <body>
    <div id="searchcontrol"></div>
  </body>

</html>