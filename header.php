<?php
session_start(); 

include('connection.php');
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  $sql_new = "
      SELECT m.title, f.movie_id 
      FROM favorites f
      INNER JOIN movies m ON f.movie_id = m.movie_id
      WHERE f.user_id = $user_id
  ";

  $result_new = mysqli_query($con, $sql_new);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png">
    <title>Film Flex</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/about.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<style>
body, html {
  margin: 0;
  padding: 0;
}
#navbar_sticky {
  position: sticky;
  top: 0;
  z-index: 9999;
  background-color: transparent;  /* Transparent background */
  width: 100%;
  padding: 0;  /* Ensure no extra padding */
  margin: 0;  /* Ensure no margin */
  box-shadow: none; /* Remove any unwanted shadow (optional) */
}

.main_1 {
    position: relative; /* Ensure it's relative without being absolute */
    width: 100%;
    margin: 0;
    padding: 0;
}


.navbar-brand {
  padding: 0;
  margin: 0;
}

.navbar-nav {
  margin: 0;
}
.submenu {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  min-width: 160px;
  background-color: #fff;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  padding: 0.5rem 0;
}
.submenu .dropdown-item {
  padding: 0.375rem 1.5rem;
  font-size: 1rem;
  color: #212529;
}

.submenu .dropdown-item:hover {
  background-color: #f8f9fa;
  color: #007bff;
}

.nav-item.dropdown:hover .submenu {
  display: block;
}
#spec {
  padding: 60px 0;
}
#spec .stream_1 h1 {
  font-size: 50px;
  color: white;
  font-weight: 600;
}

#spec .stream_1 h6 {
  color: #b3b3b3;
}
.spec_1im {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}


.spec_1im .spec_1imi img {
  width: 100%;
  transition: transform 0.3s ease;
}

.spec_1im:hover {
  transform: translateY(-10px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.spec_1im:hover .spec_1imi img {
  transform: scale(1.1);
}

.spec_1imi img {
  transition: transform 0.3s ease;
}
.spec_1imi1 {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5); 
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  opacity: 0;
  transition: opacity 0.3s ease;
  padding: 10px;
}


.spec_1im:hover .spec_1imi1 {
  opacity: 1; 
}

.spec_1imi1l h6 {
  font-size: 14px;
  font-weight: 600;
}

.spec_1imi1r h6 {
  font-size: 14px;
  font-weight: 600;
}

.rating {
  background-color: #ffcc00;
  color: white;
  padding: 3px 8px;
  border-radius: 50%;
}

.spec_1imi1 a {
  color: white;
  text-decoration: none;
}

.spec_1imi1 a:hover {
  text-decoration: underline;
}
/* Ensuring the navbar and content look responsive */
@media (max-width: 992px) {
  .col-lg-2 {
    flex: 0 0 25%; /* Adjust the width for larger tablets */
  }
}

@media (max-width: 768px) {
  .col-md-4 {
    flex: 0 0 33.33%; /* Adjust for medium-sized tablets */
  }
}

@media (max-width: 576px) {
  .col-9, .col-3 {
    flex: 0 0 50%; /* Adjust for smaller mobile screens */
  }
}

/* Styling for the favorites panel */
.favorites-panel {
  position: fixed;
  top: 0;
  left: -300px;  
  width: 300px;
  height: 100%;
  background-color: #222;
  color: #fff;
  transition: left 0.3s ease-in-out;
  padding: 20px;
  z-index: 9999;
}

.favorites-panel .panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.favorites-panel h3 {
  margin: 0;
  font-size: 20px;
}

.favorites-panel button {
  background-color: #ff0000;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
}

.favorites-panel button:hover {
  background-color: #cc0000;
}

.favorites-list {
  margin-top: 20px;
}

.favorites-list ul {
  list-style: none;
  padding-left: 0;
}

.favorites-list li {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.favorites-list button {
  background-color: #ff0000;
  color: white;
  border: none;
  cursor: pointer;
  padding: 5px 10px;
}

.favorites-list button:hover {
  background-color: #cc0000;
}

.favorite-heart {
  font-size: 24px;
  color: red;
  cursor: pointer;
  margin-left: 10px;
}

.favorite-heart:hover {
  color: darkred;
}

</style>
</head>
<body>
<div class="main clearfix position-relative">
    <div class="main_1 clearfix position-absolute top-0 w-100">
        <section id="header">
            <nav class="navbar navbar-expand-md navbar-light"  id="navbar_sticky">
                <div class="container-xl">
                    <a class="navbar-brand fs-2 p-0 fw-bold text-white m-0 me-5" href="index.php"><img src="img/logo.png" class="ik" alt="" width="220px" height="70px" style="margin-top:15px;"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-0">
                            <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                                <ul class="submenu dropdown-menu">
                                    <?php 
                                    $result = mysqli_query($con, "SELECT * FROM category");
                                    while($row = mysqli_fetch_assoc($result)) { ?>
                                        <li><a class="dropdown-item" href="category.php?category_id=<?php echo $row['category_id']?>"><?php echo $row['name']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="cinema.php">Cinema</a></li>
                        </ul>
                        <ul class="navbar-nav mb-0 ms-auto">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <li class="nav-item" style="margin-top:8px;">
                                    <i class="fas fa-heart favorite-heart" onclick="toggleFavoritesPanel()"></i>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                                <li class="nav-item"><a class="nav-link" href="setting.php">Settings</a></li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>
                                <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </section>
    </div>
</div>

<?php
    
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
  
      if (isset($_POST['action'])) {
          $movie_id = $_POST['movie_id'];
  
          if ($_POST['action'] == 'add') {
              $check_sql = "SELECT * FROM favorites WHERE user_id = $user_id AND movie_id = $movie_id";
              $check_result = mysqli_query($con, $check_sql);
  
              if (mysqli_num_rows($check_result) == 0) {
                  $sql = "INSERT INTO favorites (user_id, movie_id) VALUES ($user_id, $movie_id)";
                  if (mysqli_query($con, $sql)) {
                      echo "Movie added to favorites!";
                  } else {
                      echo "Error adding movie to favorites.";
                  }
              } else {
                  echo "Movie is already in your favorites.";
              }
          }
  
          if ($_POST['action'] == 'remove') {
              $sql = "DELETE FROM favorites WHERE user_id = $user_id AND movie_id = $movie_id";
              if (mysqli_query($con, $sql)) {
                  echo "Movie removed from favorites!";
              } else {
                  echo "Error removing movie from favorites.";
              }
          }
      }
  
      $sql_new = "
          SELECT m.title, f.movie_id
          FROM favorites f
          INNER JOIN movies m ON f.movie_id = m.movie_id
          WHERE f.user_id = $user_id
      ";
      $result_new = mysqli_query($con, $sql_new);
  }
    ?>

<div id="favoritesPanel" class="favorites-panel">
    <div class="panel-header">
        <h3>My Favorites</h3>
        <button onclick="closeFavoritesPanel()">Close</button>
    </div>
    <div id="favoritesList" class="favorites-list">
        <ul id="favoriteMoviesList">
            <?php 
            if (isset($result_new) && mysqli_num_rows($result_new) > 0) {
               
                while ($row = mysqli_fetch_assoc($result_new)) { ?>
                    <li>
                        <a href="description.php?movie_id=<?php echo $row['movie_id']; ?>">
                            <?php echo $row['title']; ?>
                        </a>
                        <button onclick="removeFromFavorites(<?php echo $row['movie_id']; ?>)">Remove</button>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li>No favorite movies added yet.</li>
            <?php } ?>
        </ul>
    </div>
</div>
    

</body>
</html>
<script>
     function toggleFavoritesPanel() {
    const panel = document.getElementById('favoritesPanel');
    const isOpen = panel.style.left === '0px'; 
    if (isOpen) {
        closeFavoritesPanel();
    } else {
        openFavoritesPanel();
    }
}
function openFavoritesPanel() {
    const panel = document.getElementById('favoritesPanel');
    populateFavoritesList();   
    panel.style.left = '0px';  
}
function removeFromFavorites(movieId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'remove_favorite.php', true);  
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            if (xhr.responseText === 'success') {
                alert('Movie removed from favorites!');
                populateFavoritesList(); 
            } else {
                alert('Error removing movie from favorites.');
            }
        }
    };
    
    xhr.send('movie_id=' + movieId);
}

function closeFavoritesPanel() {
    const panel = document.getElementById('favoritesPanel');
    panel.style.left = '-300px'; 
}
function populateFavoritesList() {
    const list = document.getElementById('favoriteMoviesList');
    list.innerHTML = ''; 

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_favorites.php', true); 
    xhr.onload = function() {
        if (xhr.status === 200) {
            const favorites = JSON.parse(xhr.responseText);
            if (favorites.length > 0) {
                favorites.forEach(function(favorite) {
                    const listItem = document.createElement('li');
                    listItem.textContent = favorite.title; 
                    
                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'Remove';
                    removeButton.onclick = function() {
                        removeFromFavorites(favorite.movie_id);  
                    };
                    
                    listItem.appendChild(removeButton);
                    list.appendChild(listItem);
                });
            } else {
                list.innerHTML = "<li>No favorite movies added yet.</li>";  
            }
        }
    };
    xhr.send();
}

</script>