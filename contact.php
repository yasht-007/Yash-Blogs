<?php

require "admin/includes/connection.php";

?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Contact - Yash Tiwari</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="css/styles.css">

    <!-- script
    ================================================== -->
    <script src="js/modernizr.js"></script>
    <script defer src="js/fontawesome/all.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

</head>

<body id="top">

    <?php include "header-opaque.php"; ?>

    <!-- content
    ================================================== -->
    <section class="s-content">

        <div class="row">
            <div class="column large-12">

                <article class="s-content__entry">

                    <div class="s-content__media">
                        <img src="images/thumbs/contact/contact-1050.jpg" srcset="images/thumbs/contact/contact-2100.jpg 2100w, 
                                        images/thumbs/contact/contact-1050.jpg 1050w, 
                                        images/thumbs/contact/contact-525.jpg 525w" sizes="(max-width: 2100px) 100vw, 2100px" alt="">
                    </div> <!-- end s-content__media -->

                    <div class="s-content__entry-header">
                        <h1 class="s-content__title">Get In Touch With Us.</h1>
                    </div> <!-- end s-content__entry-header -->

                    <div class="s-content__primary">

                        <div class="s-content__page-content">

                            <div class="row block-large-1-2 block-tab-full s-content__blocks">
                                <div class="column">
                                    <h4>Where to Find Us</h4>
                                    
            <ul style="list-style-type: none;">
            <li><a href="https://www.facebook.com/yashtiwari40/"><i class="fab fa-facebook-f" aria-hidden="true" style="font-size:28px"></i> - Facebook</a>&nbsp;</li>

            <li><a href="https://twitter.com/Yash06981451"><i class="fab fa-twitter" aria-hidden="true" style="font-size:28px"></i> - Twitter</a>&nbsp;</li>
                <li><a href="https://www.instagram.com/yasht.007/"><i class="fab fa-instagram" aria-hidden="true" style="font-size:28px"></i> - Instagram</a>&nbsp;</li>
                <li><a href="https://telegram.org/yashudn"><i class="fab fa-telegram" aria-hidden="true" style="font-size:28px"></i>- Telegram</a>&nbsp;</li>
                
            </ul>
        
                        
             </div>

                                <div class="column">
                                    <h4>Contact Info</h4>
                                    <p>
                                    <b>Email</b> - yashd2d@gmail.com
                                        Phone: (+91) 8057881747
                                    </p>
                                </div>
                            </div> <!-- end s-content__blocks -->



                            <form name="cForm" id="cForm" class="s-content__form" method="post" action="">
                                <fieldset>

                                    <div class="form-field">
                                        <input name="cName" type="text" id="cName" class="h-full-width h-remove-bottom" placeholder="Your Name" value="">
                                    </div>

                                    <div class="form-field">
                                        <input name="cEmail" type="text" id="cEmail" class="h-full-width h-remove-bottom" placeholder="Your Email" value="">
                                    </div>

                                    <div class="form-field">
                                        <input name="cWebsite" type="text" id="cWebsite" class="h-full-width h-remove-bottom" placeholder="Website" value="">
                                    </div>

                                    <div class="message form-field">
                                        <textarea name="cMessage" id="cMessage" class="h-full-width" placeholder="Your Message"></textarea>
                                    </div>

                                    <br>
                                    <button type="submit" class="submit btn btn--primary h-full-width">Submit</button>

                                </fieldset>
                            </form> <!-- end form -->

                        </div> <!-- end s-entry__page-content -->

                    </div> <!-- end s-content__primary -->
                </article> <!-- end entry -->

            </div> <!-- end column -->
        </div> <!-- end row -->

    </section> <!-- end s-content -->

    <?php include "footer.php"; ?>

    <!-- Java Script
    ================================================== -->
    <script src="js/jquery-3.5.0.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

</body>

</html>