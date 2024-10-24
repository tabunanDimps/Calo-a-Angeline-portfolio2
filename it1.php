<?php 
session_start();
include("config.php");
if(!isset($_SESSION['valid'])){
    header('Location: index.php');
}
include 'includes/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>USTP E-voting System</title>
    <link rel="stylesheet" type="text/css" href="it.css"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/release/v5.10.0/css/all.css"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
    <section class="scroll-container">
        <img class="it-img" src="img/it.png" alt="">
        <div class="info-container">
            <h1>BACHELOR OF INFORMATION TECHNOLOGY</h1> 
            <p>LEADING ADVOCATING AND UNIFYING MINDS<br>
            We are honored and thrilled to present to you the PAG-L.A.U.M PARTY LIST.<br>
            The PAG-L.A.U.M PARTY LIST is driven by a steadfast commitment to integrity, transparency, and accountability.<br> We recognize the responsibility entrusted to us by our fellow members, and we pledge to serve with utmost  <br> dedication and diligence, always mindful of the impact our decisions have on the collective.
            <br> "Building Futures, One Student at a Time: Uniting Minds, Shaping Excellence."</p>
        </div>
    </section>

    <div id="swipers-container" class="swiper-container"></div>


    <div class="button-container"> 
        <a href="hehe.php"><button class="button">Vote Now</button></a> 
        <br> 
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var candidatesByPosition = {};

            <?php
            $sql = "SELECT * FROM candidate";
            $result = $con->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    
                    echo "var position = '" . $row['position'] . "';";
                    echo "if (!candidatesByPosition[position]) {";
                    echo "candidatesByPosition[position] = [];";
                    echo "}";
                    echo "candidatesByPosition[position].push(" . json_encode($row) . ");";
                }
            }
            ?>

            var swipersContainer = document.getElementById("swipers-container");
            for (var position in candidatesByPosition) {
                if (candidatesByPosition.hasOwnProperty(position)) {
                    var swiperContainer = document.createElement("section");
                    swiperContainer.className = "swiper mySwiper";
                    swiperContainer.innerHTML = '<div class="swiper-wrapper"></div>';
                    swipersContainer.appendChild(swiperContainer);

                    var candidates = candidatesByPosition[position];
                    var swiperWrapper = swiperContainer.querySelector(".swiper-wrapper");

                    candidates.forEach(function(candidate) {
                    var card = document.createElement("div");
                    card.className = "card swiper-slide";
                    card.innerHTML = '<div class="card_content">' +
                                        '<div class="card_info">' +
                                            '<img src="' . $photo . '" alt="' . $first_name . ' ' . $last_name . '" class="candidate-photo">' +
                                            '<h1 class="card_name">' + candidate.first_name + ' ' + candidate.last_name + '</h1>' +
                                            '<p class="card_position">' + candidate.position + '</p>' +
                                            '<p class="card_platform">' + candidate.platform + '</p>' +
                                        '</div>' +
                                    '</div>';
                    swiperWrapper.appendChild(card);
                    });
                }
            }

            var swiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 300,
                    modifier: 1,
                    slideShadows: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                },
            });
        });
    </script>
</body>
</html>

