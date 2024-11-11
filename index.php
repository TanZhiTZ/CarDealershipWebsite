<?php
include_once 'header2.php';

if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];
    $id = $_SESSION['user_id'];
    echo "User id: " . $id;
    echo "User name: " . $name;
}
?>

<head>

    <style>

        /* Carousel Models */
        .wrapper {
            max-width: 1200px;
            position: relative;
        }

        .wrapper i {
            background: #fff;
            height: 46px;
            width: 46px;
            cursor: pointer;
            font-size: 1.2rem;
            text-align: center;
            line-height: 46px;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .wrapper i:first-child {
            left: -23px;
            /* display: none; */
        }

        .wrapper i:last-child {
            right: -23px;
        }

        .wrapper .carousel2 {
            white-space: nowrap;
            /** make the image horizontal */
            font-size: 0px;
            cursor: pointer;
            overflow: hidden;
            scroll-behavior: smooth;
        }

        .carousel2.dragging {
            cursor: grab;
            scroll-behavior: auto;
        }

        .carousel2.dragging img {
            pointer-events: none;
        }

        .carousel2 img {
            /* height: 340px; */
            width: calc(100%/3);
            margin-left: 14px;
            object-fit: cover;
        }

        .carousel2 img:first-child {
            margin-left: 0px;
        }


        /* References */
        .features-container {
            max-width: 1100px;
            position: relative;
            margin: 0 auto;
            padding-left: 15px;
            padding-right: 15px;
        }



        .text {
            padding: 10px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            letter-spacing: 0.5px;

        }

        .icon-style {
            color: black;
        }

        .icon-style:hover .icon {
            transform: scale(1.2);
            color: red;
            /* Increase the size on hover (adjust as needed) */
            transition: transform 0.2s ease;
            /* Add a smooth transition effect */
        }

        .icon-style:hover {
            text-decoration: none;
        }

        .custom-row-width {
            width: 1519px;

        }
    </style>


</head>

<section style="padding-top:100px;">
    <!-- Carousel Images -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="img/home1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/home2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/home3.jpeg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

<?php 
    $select = mysqli_query($conn, "SELECT * FROM carinformation");
?>
<!-- Carausel Modesl-->
<section style="width: 100%; padding:4em 0; background-color:black;">
    <h3 style="color:white;">EXPLORE ALL MODELS</h3>
    <div class="wrapper" style="margin:0 auto;">
        <i id="left" class="fa-solid fa-angle-left"></i>
        <div class="carousel2">
        <?php while($crow = mysqli_fetch_assoc($select)){ ?>
            <a href="carInformation.php?model=<?php echo $crow['model']; ?>" title="<?php echo $crow['model']; ?>"><img src="img/<?php echo $crow['model']; ?>/<?php echo $crow['homeimage']; ?>" alt="img1"></a>
            <?php } ?>
        </div>
        <i id="right" class="fa-solid fa-angle-right"></i>
    </div>
</section>


<section>
    <div style="width: 100%; padding:4em 0; background-color:#eeeeee;">
        <div class="features-container">
            <div class="row">
                <div class="col-md-12 text-center" style="padding-bottom: 30px;">
                    <h2>HONDA</h2>
                    <h3>“THE POWER OF DREAMS”</h3>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-md-3"></div> -->
                <div class="col-md-4">
                    <a href="#compare" class="icon-style">
                        <div class="text-center">
                            <div class="icon" style="margin: auto;"><i class="fa fa-compress fa-2x"
                                    aria-hidden="true"></i></i>
                                <div class="text">Compare Models</div>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-4">
                    <a href="calculator.php" class="icon-style">
                        <div class="text-center">
                            <div class="icon" style="margin: auto;"><i class="fa fa-calculator fa-2x"
                                    aria-hidden="true"></i></i>
                                <div class="text">Loan Calculator</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#prebook" class="icon-style">
                        <div class="text-center">
                            <div class="icon" style="margin: auto;"><i class="fa fa-id-card fa-2x"
                                    aria-hidden="true"></i></i>
                                <div class="text">Pre-Booking</div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>




<section>
    <div class="container" style="max-width:1519px; padding:0px; margin:0;">
        <div class="row custom-row-width">
            <div class="col-lg-6"
                style="background-image: url(img/home3.jpg); background-size:contain; background-repeat:no-repeat; height:429px; min-width:750px; padding:0">
            </div>
            <div class="col-lg-6" style="min-width:750px; display: flex; justify-content: center; align-items: center;">
                <div class="text-center">
                    <h2>“Advancing Together, Empowering All”</h2>
                    <p>Without civic morality communities perish;</br>without personal morality their survival has no
                        value.</p>
                </div>
            </div>
        </div>
        <div class="row custom-row-width">
            <div class="col-lg-6" style="min-width:750px; display: flex; justify-content: center; align-items: center;">
                <div class="text-center">
                    <h2>“Heighten your Senses”</h2>
                    <p>Sporty driving characteristics and spacious interior.</p>
                </div>
            </div>
            <div class="col-lg-6"
                style="background-image: url(img/home4.jpg); background-size:contain; background-repeat:no-repeat; height:429px; min-width:750px; padding:0;right:0">
            </div>
        </div>
        <div class="row custom-row-width">
            <div class="col-lg-6"
                style="background-image: url(img/home5.jpg); background-size:contain; background-repeat:no-repeat; height:429px; min-width:750px; padding:0">
            </div>
            <div class="col-lg-6" style="min-width:750px; display: flex; justify-content: center; align-items: center;">
                <div class="text-center">
                    <h2>“Comfortable Runabout Vehicle”</h2>
                    <p>The ultimate SUV, always CR-V.</br>Its advantage is undeniable, its legacy unquestionable.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    //slide on move mouse
    const carousel = document.querySelector(".carousel2");
    firstImg = carousel.querySelectorAll("img")[0];
    //button
    arrowIcons = document.querySelectorAll(".wrapper i");

    //slide on move mouse click
    let isDragStart = false, prevPageX, prevScrollLeft;
    let firstImgWidth = firstImg.clientWidth + 14;//getting first img width & adding 14 margin value
    let scrollWidth = carousel.scrollWidth - carousel.clientHeight; //getting max scrollable with


    arrowIcons.forEach(icon => {
        icon.addEventListener("click", () => {
            //if clicked icon is left, reduce width value from the carousel scroll left else add to it
            carousel.scrollLeft += icon.id == "left" ? -firstImgWidth : firstImgWidth;
            // setTimeout(() => showHideIcons(), 60); //calling showHideIcons after 60ms
        });
    });

    const dragStart = (e) => {
        //updating global variables value on mouse down event
        isDragStart = true;
        prevPageX = e.pageX;
        prevScrollLeft = carousel.scrollLeft;
    }

    const dragging = (e) => {
        //scrolling images/carousel to left according to mouse pointer
        if (!isDragStart) return;
        e.preventDefault();
        carousel.classList.add("dragging");
        let positionDiff = e.pageX - prevPageX;
        carousel.scrollLeft = prevScrollLeft - positionDiff; //pageX returns the horizontal coordinate of mouse pointer
    }

    const dragStop = () => {
        isDragStart = false;
        carousel.classList.remove("dragging");
    }

    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("mousemove", dragging);
    carousel.addEventListener("mouseup", dragStop);

</script>

<?php
include_once 'footer.php';
?>