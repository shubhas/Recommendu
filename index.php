<?php
error_reporting(0);
$myfile = fopen("data\u.item", "r") or die("Unable to open file!");

// random number generation
$random_number_array = range(0, 943);
shuffle($random_number_array );
$random_number_array = array_slice($random_number_array ,0,9);
//print_r($random_number_array);

// reading a file accesing their name
$movieid = array();
$moviename = array();
while(!feof($myfile)) {
   $data = fgets($myfile);
   list($movie_id, $movie_name) = explode("|", $data);
   if( in_array($movie_id, $random_number_array)) {
    	array_push($movieid, $movie_id);
		array_push($moviename, $movie_name); 
   }
}
//print_r($movieid);
//print_r($moviename);
$movieset = array_combine($movieid, $moviename);
//print_r($movieset);
//echo fread($myfile,filesize("data\u.base"));
fclose($myfile); 

if("submit"==$_POST['submit'] && isset($_POST["star1"]) && isset($_POST["star2"]) && isset($_POST["star3"]) && isset($_POST["star4"]) && isset($_POST["star5"]) && isset($_POST["star6"]) && isset($_POST["star7"]) && isset($_POST["star8"])) {
  		$rec= array($_POST["star1"],$_POST["star2"],$_POST["star3"],$_POST["star4"],$_POST["star5"],$_POST["star6"],$_POST["star7"],$_POST["star8"],$_POST["star9"]);
		$inputfile = fopen("inputfile.txt", "w") or die("Unable to open file!");
		for($i=0;$i<9;$i++) {
			$txt = $movieid[$i]."|".$rec[$i];
			fwrite($inputfile, $txt.PHP_EOL);
		}
		fclose($inputfile);
		exec('python E:\xampp\htdocs\recommend\recommendations.py', $output);
		print_r($output);
		echo '<script>window.location = "recommend.php"</script>';	
 }
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RECOMMENDU - A Movie Recommendation Website</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<style>
@import url(http://fonts.googleapis.com/css?family=Roboto:500,100,300,700,400);
</style>


</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">RECOMMENDU</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#playlist">PlayList</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Team</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome To Our Movies Collection!</div>
                <div class="intro-heading">It's Nice To Meet You</div>
                <a href="#playlist" class="page-scroll btn btn-xl">Lets FInd Your Taste</a>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <!-- Playlist Grid Section -->
    <section id="playlist" class="bg-light-gray">
        <div class="container">
			<form action="" method="post">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Playlist</h2>
                    <h3 class="section-subheading text-muted">Rate Movies And We will give you something good to watch </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal1" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[0]; ?></h4>
                      <!--  <p class="text-muted">Action movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-51" type="radio" name="star1" value="5"/>
							  <label class="star star-5" for="star-51"></label>
							  <input class="star star-4" id="star-41" type="radio" name="star1" value="4"/>
							  <label class="star star-4" for="star-41"></label>
							  <input class="star star-3" id="star-31" type="radio" name="star1" value="3"/>
							  <label class="star star-3" for="star-31"></label>
							  <input class="star star-2" id="star-21" type="radio" name="star1" value="2"/>
							  <label class="star star-2" for="star-21"></label>
							  <input class="star star-1" id="star-11" type="radio" name="star1" value="1"/>
							  <label class="star star-1" for="star-11"></label>
						  </div>
                    </div>
              </div>
                <div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal2" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[1]; ?></h4>
                        <!--  <p class="text-muted">Love movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-52" type="radio" name="star2" value="5"/>
							  <label class="star star-5" for="star-52"></label>
							  <input class="star star-4" id="star-42" type="radio" name="star2" value="4"/>
							  <label class="star star-4" for="star-42"></label>
							  <input class="star star-3" id="star-32" type="radio" name="star2" value="3"/>
							  <label class="star star-3" for="star-32"></label>
							  <input class="star star-2" id="star-22" type="radio" name="star2" value="2"/>
							  <label class="star star-2" for="star-22"></label>
							  <input class="star star-1" id="star-12" type="radio" name="star2" value="1"/>
							  <label class="star star-1" for="star-12"></label>
						  </div>
                    </div>
      </div>
                <div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal3" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[2]; ?></h4>
                        <!--  <p class="text-muted">Horrar Movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-53" type="radio" name="star3" value="5"/>
							  <label class="star star-5" for="star-53"></label>
							  <input class="star star-4" id="star-43" type="radio" name="star3" value="4"/>
							  <label class="star star-4" for="star-43"></label>
							  <input class="star star-3" id="star-33" type="radio" name="star3" value="3"/>
							  <label class="star star-3" for="star-33"></label>
							  <input class="star star-2" id="star-23" type="radio" name="star3" value="2"/>
							  <label class="star star-2" for="star-23"></label>
							  <input class="star star-1" id="star-13" type="radio" name="star3" value="1"/>
							  <label class="star star-1" for="star-13"></label>
						  </div>                   
				  </div>
      </div>
                <div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal4" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[3]; ?></h4>
                        <!--  <p class="text-muted">Comady Movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-54" type="radio" name="star4" value="5"/>
							  <label class="star star-5" for="star-54"></label>
							  <input class="star star-4" id="star-44" type="radio" name="star4" value="4"/>
							  <label class="star star-4" for="star-44"></label>
							  <input class="star star-3" id="star-34" type="radio" name="star4" value="3"/>
							  <label class="star star-3" for="star-34"></label>
							  <input class="star star-2" id="star-24" type="radio" name="star4" value="2"/>
							  <label class="star star-2" for="star-24"></label>
							  <input class="star star-1" id="star-14" type="radio" name="star4" value="1"/>
							  <label class="star star-1" for="star-14"></label>
						  </div>
                    </div>
      </div>
                <div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal5" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[4]; ?></h4>
                        <!--  <p class="text-muted">Love Movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-55" type="radio" name="star5" value="5"/>
							  <label class="star star-5" for="star-55"></label>
							  <input class="star star-4" id="star-45" type="radio" name="star5" value="4"/>
							  <label class="star star-4" for="star-45"></label>
							  <input class="star star-3" id="star-35" type="radio" name="star5" value="3"/>
							  <label class="star star-3" for="star-35"></label>
							  <input class="star star-2" id="star-25" type="radio" name="star5" value="2"/>
							  <label class="star star-2" for="star-25"></label>
							  <input class="star star-1" id="star-15" type="radio" name="star5" value="1"/>
							  <label class="star star-1" for="star-15"></label>
						  </div>
                    </div>
      </div>
                <div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal6" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[5]; ?></h4>
                        <!--  <p class="text-muted">Dance Movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-56" type="radio" name="star6" value="5"/>
							  <label class="star star-5" for="star-56"></label>
							  <input class="star star-4" id="star-46" type="radio" name="star6" value="4"/>
							  <label class="star star-4" for="star-46"></label>
							  <input class="star star-3" id="star-36" type="radio" name="star6" value="3"/>
							  <label class="star star-3" for="star-36"></label>
							  <input class="star star-2" id="star-26" type="radio" name="star6" value="2"/>
							  <label class="star star-2" for="star-26"></label>
							  <input class="star star-1" id="star-16" type="radio" name="star6" value="1"/>
							  <label class="star star-1" for="star-16"></label>
						  </div>
                    </div>
      </div>
				<div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal6" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[6]; ?></h4>
                        <!--  <p class="text-muted">Dance Movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-57" type="radio" name="star7" value="5"/>
							  <label class="star star-5" for="star-57"></label>
							  <input class="star star-4" id="star-47" type="radio" name="star7" value="4"/>
							  <label class="star star-4" for="star-47"></label>
							  <input class="star star-3" id="star-37" type="radio" name="star7" value="3"/>
							  <label class="star star-3" for="star-37"></label>
							  <input class="star star-2" id="star-27" type="radio" name="star7" value="2"/>
							  <label class="star star-2" for="star-27"></label>
							  <input class="star star-1" id="star-17" type="radio" name="star7" value="1"/>
							  <label class="star star-1" for="star-17"></label>
						  </div>
                    </div>
      </div>
				<div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal6" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[7]; ?></h4>
                        <!--  <p class="text-muted">Dance Movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-58" type="radio" name="star8" value="5"/>
							  <label class="star star-5" for="star-58"></label>
							  <input class="star star-4" id="star-48" type="radio" name="star8" value="4"/>
							  <label class="star star-4" for="star-48"></label>
							  <input class="star star-3" id="star-38" type="radio" name="star8" value="3"/>
							  <label class="star star-3" for="star-38"></label>
							  <input class="star star-2" id="star-28" type="radio" name="star8" value="2"/>
							  <label class="star star-2" for="star-28"></label>
							  <input class="star star-1" id="star-18" type="radio" name="star8" value="1"/>
							  <label class="star star-1" for="star-18"></label>
						  </div>
                    </div>
      </div>
				<div class="col-md-4 col-sm-6 playlist-item">
                    <a href="#playlistModal6" class="playlist-link" data-toggle="modal">
                        <div class="playlist-hover">
                            <div class="playlist-hover-content">
                                <i class="fa fa-plus fa-3x"></i>                            </div>
                        </div>
                    <img src="img/playlist/roundicons.png" class="img-responsive" alt="">                    </a>
                    <div class="playlist-caption">
                        <h4><?php echo $moviename[8]; ?></h4>
                        <!--  <p class="text-muted">Dance Movie</p> -->
						  <div class="stars">
							  <input class="star star-5" id="star-59" type="radio" name="star9" value="5"/>
							  <label class="star star-5" for="star-59"></label>
							  <input class="star star-4" id="star-49" type="radio" name="star9" value="4"/>
							  <label class="star star-4" for="star-49"></label>
							  <input class="star star-3" id="star-39" type="radio" name="star9" value="3"/>
							  <label class="star star-3" for="star-39"></label>
							  <input class="star star-2" id="star-29" type="radio" name="star9" value="2"/>
							  <label class="star star-2" for="star-29"></label>
							  <input class="star star-1" id="star-19" type="radio" name="star9" value="1"/>
							  <label class="star star-1" for="star-19"></label>
						  </div>
                    </div>
      </div>
				<input type="submit" name="submit" value="submit" class="btn btn-primary btn-block"/>
              </div>
			</form>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Our Amazing Team</h2>
                    <h3 class="section-subheading text-muted">Dedicated Team of Passionate individuals</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/playlist/roundicons.png" class="img-responsive img-circle" alt="">
                        <h4>Pukhraj Panwar</h4>
                      <p class="text-muted">Passionate</p> 
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/playlist/roundicons.png" class="img-responsive img-circle" alt="">
                        <h4>Amrita Singh</h4>
                       <p class="text-muted">Hardworking</p> 
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/playlist/roundicons.png" class="img-responsive img-circle" alt="">
                        <h4>Shubham Jain</h4>
                      	<p class="text-muted">Always Dedicated</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                </div>
            </div>
        </div>
    </section>

    <!-- Clients Aside -->
 
    <!-- Contact Section -->
   

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Recommendu 2016</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>



    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>

</html>
