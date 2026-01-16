<?php
include ('header.php');
include ('connection.php');
$sql = "SELECT m.movie_id, m.title, m.rating, m.duration, m.release_date, m.description, m.genre, m.poster_url, m.trailer_url
        FROM movies AS m
        ORDER BY m.movie_id ASC
        LIMIT 12";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<p>No movies found in this category.</p>";
}
$sql_r = "
    SELECT r.review_id, r.movie_id, r.user_id, r.name, r.rating, r.comment, m.title
    FROM reviews r
    JOIN movies m ON r.movie_id = m.movie_id
    LIMIT 2
"; 
$result_r = mysqli_query($con, $sql_r); 

$reviews = [];
if ($result_r) {
    while ($row = mysqli_fetch_assoc($result_r)) {
        $reviews[] = $row; 
    }
} else {
    $reviews = [];
}

?>

 </div>
 <div class="main_2 clearfix">
   <section id="center" class="center_home">
 <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2" class="" aria-current="true"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/movie character 2.jpg" class="d-block w-100" alt="..." style="  filter: brightness(20%);">
      <div class="carousel-caption d-md-block">
         <h5 class="text-white-50 release ps-2 fs-6">SCREEN ON</h5>
        <h1 class="font_80 mt-4">Avengers<br> End Game</h1>
		<h6 class="text-white"><span class="rating d-inline-block rounded-circle me-2 col_green">8.2</span> <span class="col_green">IMDB SCORE</span> <span class="mx-3">2021</span> <span class="col_red">Romance, Action,Emotion</span></h6>
		 <p class="mt-4">With half of all life wiped out by Thanos, the Avengers must come together to undo the devastation, risking everything in a final battle to restore the universe and bring their lost friends back home.</p>
		<h5 class="mb-0 mt-4 text-uppercase"><a class="button" href="cinema.php"><i class="fa fa-youtube-play me-1"></i> View Cinema</a></h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/banner.jpg" class="d-block w-100" alt="..." style="  filter: brightness(20%);">
      <div class="carousel-caption d-md-block">
         <h5 class="text-white-50 release ps-2 fs-6">ALL NEW MOVIES</h5>
        <h1 class="font_80 mt-4">Detail Of Popular<br>  New Show</h1>
		<h6 class="text-white"><span class="rating d-inline-block rounded-circle me-2 col_green">10</span> <span class="col_green">IMDB SCORE</span> <span class="mx-3">2024</span> <span class="col_red">Romance, Action,Fantanstic,Anime</span></h6>
		 <p class="mt-4">Other releases include family-friendly holiday movies like The Best Christmas Pageant Ever and thrillers like He Never Left. Let me know if you’d like details on specific genres or other upcoming films.</p>
		<h5 class="mb-0 mt-4 text-uppercase"><a class="button" href="#scroll"><i class="fa fa-youtube-play me-1"></i> List Movie</a></h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/ticket 3.jpg" class="d-block w-100" alt="..." height="800px" style="  filter: brightness(20%);">
      <div class="carousel-caption d-md-block">
         <h5 class="text-white-50 release ps-2 fs-6">NEW & OLD</h5>
        <h1 class="font_80 mt-4">New Experience <br> Entertainment</h1>
		<h6 class="text-white"><span class="rating d-inline-block rounded-circle me-2 col_green">9.9</span> <span class="col_green">IMDB SCORE</span> <span class="mx-3">2024</span> <span class="col_red">Romance, Action</span></h6>
		 <p class="mt-4">Booking a cinema ticket has become incredibly convenient with the advent of online and app-based platforms. To reserve a seat, you typically start by selecting your preferred movie, date, and time from the schedule
		 </p>
		<h5 class="mb-0 mt-4 text-uppercase"><a class="button" href="category.php?category_id=1"><i class="fa fa-youtube-play me-1"></i> Book Tickets</a></h5>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</section>
 </div>
 
</div>

<section id="stream" class="p_3">
<div class="container-xl">
 <div class="row stream_1">
  <div class="col-md-12">
   <h6 class="col_red">ONLINE STREAMING Trailer</h6>
   <h1 class="mb-0">Watch Online Trailer</h1>
  </div>
 </div>
 <div class="row stream_2 mt-4">
  <div class="col-md-3 pe-0">
    <div class="stream_2im clearfix position-relative">
	  <div class="stream_2im1 clearfix">
	    <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/holly.jpeg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	  </div>
	  <div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0  clearfix">
	   <h6 class="font_20 col_red">Movies</h6>
	   <h4 class="text-white">Hollywood</h4>
	   <h6 class="font_14 mb-0 text-white"><a class="text-white me-1 font_60 align-middle lh-1" href="category.php?category_id=2"><i class="fa fa-play-circle"></i></a> See-All</h6>
	  </div>
	</div>
  </div>
  <div class="col-md-3 pe-0">
    <div class="stream_2im clearfix position-relative">
	  <div class="stream_2im1 clearfix">
	    <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/bollywood.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	  </div>
	  <div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0  clearfix">
	   <h6 class="font_20 col_red">Movies</h6>
	   <h4 class="text-white">Bollywood</h4>
	   <h6 class="font_14 mb-0 text-white"><a class="text-white me-1 font_60 align-middle lh-1" href="category.php?category_id=3"><i class="fa fa-play-circle"></i></a> See-All</h6>
	  </div>
	</div>
  </div>
  <div class="col-md-3 pe-0">
    <div class="stream_2im clearfix position-relative">
	  <div class="stream_2im1 clearfix">
	    <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/kids.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	  </div>
	  <div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0  clearfix">
	   <h6 class="font_20 col_red">Popular Movie</h6>
	   <h4 class="text-white">Kids</h4>
	   <h6 class="font_14 mb-0 text-white"><a class="text-white me-1 font_60 align-middle lh-1" href="category.php?category_id=4"><i class="fa fa-play-circle"></i></a> See-All</h6>
	  </div>
	</div>
  </div>
  <div class="col-md-3 pe-0">
    <div class="stream_2im clearfix position-relative">
	  <div class="stream_2im1 clearfix">
	    <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/anime.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	  </div>
	  <div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0  clearfix">
	   <h6 class="font_20 col_red">Series</h6>
	   <h4 class="text-white">Anime</h4>
	   <h6 class="font_14 mb-0 text-white"><a class="text-white me-1 font_60 align-middle lh-1" href="category.php?category_id=1"><i class="fa fa-play-circle"></i></a> See-All</h6>
	  </div>
	</div>
  </div>
 </div>
</div>
</section>

<section id="exep" class="p_3 bg-light">
<div class="container-xl">
  <div class="row exep1">
   <div class="col-md-6">
    <div class="exep1l">
	  <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/new.jpg" class="w-100" alt="abc" height="450px"></a>
				  </figure>
			  </div>
	</div>
   </div>
   <div class="col-md-6">
    <div class="exep1r">
	 <h1 class="mb-0">Best pick for hassle-Paid streaming experience.</h1>
	 <div class="exep1ri row mt-4">
	  <div class="col-md-2">
	   <div class="exep1ril">
	    <span class="font_60"><i class="fa fa-suitcase lh-1 col_red"></i></span>
	   </div>
	  </div>
	  <div class="col-md-10">
	   <div class="exep1rir">
	     <h5 class="fs-4">Access while traveling</h5>
		 <p class="mb-0">Keep access to your entertainment content while roaming the world.Pick from thousands.</p>
	   </div>
	  </div>
	 </div>
	 <div class="exep1ri row mt-4">
	  <div class="col-md-2">
	   <div class="exep1ril">
	    <span class="font_60"><i class="fa fa-desktop lh-1 col_red"></i></span>
	   </div>
	  </div>
	  <div class="col-md-10">
	   <div class="exep1rir">
	     <h5 class="fs-4">Stream with no interruptions</h5>
		 <p class="mb-0">Keep access to your entertainment content while roaming the world.Pick from thousands.</p>
	   </div>
	  </div>
	 </div>
	 <div class="exep1ri row mt-4">
	  <div class="col-md-2">
	   <div class="exep1ril">
	    <span class="font_60"><i class="fa fa-lock lh-1 col_red"></i></span>
	   </div>
	  </div>
	  <div class="col-md-10">
	   <div class="exep1rir">
	     <h5 class="fs-4">Stay secure at all times</h5>
		 <p class="mb-0">Keep access to your entertainment content while roaming the world.Pick from thousands.</p>
	   </div>
	  </div>
	 </div>
	</div>
   </div>
  </div>
</div>
</section>
<section id="spec" class="p_3 bg_dark">
  <div class="container-xl" id="scroll">
    <div class="row stream_1 text-center">
      <div class="col-md-12">
        <h6 class="text-white-50">FIND ANYWHERE ELSE</h6>
        <h1 class="mb-0 text-white font_50">Shows For You</h1>
      </div>
    </div>
    <div class="row spec_1 mt-4">
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div class="col-lg-2 pe-0 col-md-4">
      
    <div class="spec_1imi clearfix">
      <div class="spec_1im clearfix position-relative movie-card">
        
      <a href="description.php?movie_id=<?php echo isset($row['movie_id']) ? htmlspecialchars($row['movie_id']) : '0'; ?>" class="movie-card-link">
            <img src="../admin/<?php echo $row['poster_url']; ?>" class="w-100" alt="Movie Poster" height="300px" style="margin:10px;">
          </div>
          <div class="spec_1imi1 row m-0 w-100 h-100 clearfix position-absolute bg_col top-0">
            <div class="col-md-9 col-9 p-0">
              <div class="spec_1imi1l pt-2">
                <h6 class="mb-0 font_14 d-inline-block">
                  <a class="bg-black d-block text-white"> 
                    <span class="pe-2 ps-2">1080</span> 
                    <span class="bg-white d-inline-block text-black span_2"> HD</span>
                  </a>
                </h6>
              </div>
            </div>
            <div class="col-md-3 col-3 p-0">
              <div class="spec_1imi1r">
                <h6 class="text-white">
                  <span class="rating d-inline-block rounded-circle me-2 col_green"><?php echo $row['rating']; ?></span>
                </h6>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  <?php } ?>
</div>

  </div>
</section>
<section id="testim" class="p_3 pb-5">
    <div class="container-xl">
        <div class="row stream_1 text-center">
            <div class="col-md-12">
                <h6 class="text-uppercase col_red">Testimonials</h6>
                <h1 class="mb-0 font_50">Trusted by tech experts and <br> real users</h1>
            </div>
        </div>
        <div class="row testim_1 mt-4">
            <div id="carouselExampleCaptions2" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php
                    foreach ($reviews as $index => $review) {
                        echo '<button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="' . $index . '" class="' . ($index === 0 ? 'active' : '') . '" aria-label="Slide ' . ($index + 1) . '" ' . ($index === 0 ? 'aria-current="true"' : '') . '></button>';
                    }
                    ?>
                </div>
                <div class="carousel-inner">
    <?php
    foreach ($reviews as $index => $review) {
        $movie_id = $review['movie_id'];
        $sql_movie = "SELECT title FROM movies WHERE movie_id = $movie_id";
        $result_movie = mysqli_query($con, $sql_movie);
        $movie = mysqli_fetch_assoc($result_movie);
        $movie_title = $movie['title'];  
        
        $isActive = $index === 0 ? 'active' : '';
        ?>
        <div class="carousel-item <?php echo $isActive; ?>">
            <div class="testim_1i row">
                <div class="col-md-12">
                    <div class="testim_1i1 text-center p-4 pt-5 pb-5 bg_dark rounded">
                        <h3 class="col_red mt-3"><?php echo htmlspecialchars($movie_title); ?></h3> 
                        
                        <img src="../admin/img/user.png" alt="User" class="rounded-circle" height="50px">
                        <h4 class="col_red mt-3"><?php echo htmlspecialchars($review['name']); ?></h4>
                        <h6 class="fw-normal text-muted">User, Our First Clients.</h6>
                        
                        <p class="text-light"><?php echo htmlspecialchars($review['comment']); ?></p>
                        
                        <span class="col_red">
                            <?php
                            $rating = (int)$review['rating'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $rating) {
                                    echo '<i class="fa fa-star"></i>';  
                                } else {
                                    echo '<i class="fa fa-star-half-o"></i>';
                                }
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

            </div>
        </div>
    </div>
</section>
<section id="movies">
  <div class="container-xl pt-5 pb-5">
    <div class="row text-center">
      <div class="col-md-12">
        <h6 class="text-uppercase text-muted">Discover Your Favorites</h6>
        <h1 class="mb-0 font_50">Top Movies of the Week</h1>
      </div>
    </div>
    <div class="row mt-4">
        <?php
        $sql_c = "SELECT movie_id, title, genre, poster_url, rating FROM movies WHERE movie_id IN (2, 4, 7, 11)";
        $result_movies = mysqli_query($con, $sql_c);

        if ($result_movies && mysqli_num_rows($result_movies) > 0) {
            while ($movie = mysqli_fetch_assoc($result_movies)) {
                ?>
                <div class="col-md-3 mb-4">
                    <a href="description.php?movie_id=<?php echo $movie['movie_id']; ?>" class="text-decoration-none">
                        <div class="movie-card card">
                            <img src="../admin/<?php echo htmlspecialchars($movie['poster_url']); ?>" class="card-img-top" alt="Movie Poster">
                            <div class="card-body">
                                <h5 class="card-title" style="color:red;"><?php echo htmlspecialchars($movie['title']); ?></h5>
                                <p class="card-text text-muted">Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                                <div class="rating">
                                    <span class="badge bg-danger text-dark">Rating: <?php echo htmlspecialchars($movie['rating']); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
        } else {
            echo '<p>No movies found for the specified IDs.</p>';
        }
        ?>
    </div>
  </div>
</section>
<style>

#movies {
  background-color: #000;
  color: #fff;
}

#movies .container-xl {
  padding-top: 50px;
  padding-bottom: 50px;
}

#movies .row.text-center {
  margin-bottom: 30px;
}

#movies .row.text-center h6 {
  color: #bbb;
  text-transform: uppercase;
  font-size: 16px;
}

#movies .row.text-center h1 {
  font-size: 50px;
  margin-bottom: 0;
}

.movie-card {
  background-color: #333; 
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s ease; 
  height: 100%;
}

.movie-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.movie-card .card-body {
  text-align: center;
  padding: 20px;
}

.movie-card .card-title {
  font-size: 18px;
  margin-top: 15px;
}

.movie-card .card-text {
  font-size: 14px;
  color: #ccc;
}

.movie-card .rating {
  margin-top: 10px;
}

.movie-card .rating .badge {
  font-size: 14px;
  background-color: #dc3545;
}

.movie-card:hover {
  transform: translateY(-10px); 
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); 
}

@media (max-width: 1200px) {
  .movie-card {
    height: 100%;
  }
}

@media (max-width: 768px) {
  #movies .row.mt-4 {
    display: flex;
    flex-wrap: wrap;
  }

  #movies .col-md-3 {
    flex: 1 0 48%;
    margin-bottom: 20px;
  }
}

@media (max-width: 576px) {
  #movies .col-md-3 {
    flex: 1 0 100%;
  }
}
</style>
<?php 
include ('footer.php');
?>