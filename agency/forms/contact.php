<?php
require_once 'PHPMailer/PHPMailerAutoload.php';
include 'connection.php';


                    if(isset($_POST["recover-submit"])){
                      //echo $_POST["email"];

                      $res = mysqli_query($link,"SELECT * FROM users WHERE email = '$_POST[email]';");
                      $row = mysqli_fetch_array($res);

                      if(empty($row)){
                          echo '<span style="color: red;">Incorrect E-mail.Please try Again.</span>';
                      }else{
                        $key = rand(100001, 999999);

                        //delete existing keys
                        mysqli_query($link,"DELETE FROM reset WHERE email ='$_POST[email]'");

                        mysqli_query($link,"INSERT INTO reset VALUES('','$_POST[email]','$key')");

                        //email function starts
                        $mail = new PHPMailer;

                        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

                        $mail->isSMTP();                                      // Set mailer to use SMTP
                        $mail->Host = 'smtp.gmail.com';                        // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                        $mail->Username = 'salithak3@gmail.com';                 // SMTP username
                        $mail->Password = 'rexgentium...';                           // SMTP password
                        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = 587;                                    // TCP port to connect to

                        $mail->setFrom('no-reply@sanjayalali.lk', 'Sanjaya Lali Agents');
                        $mail->addAddress($_POST["email"]);     // Add a recipient
                        
                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = 'Password Reset';
                        $mail->Body    = 'Your Verification Code is <b>' .$key. ' </b> ';
                        $mail->AltBody = 'Your Verification Code is <b>' .$key. ' </b> ';

                        if(!$mail->send()) {
                            echo 'Message could not be sent.';
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                          header("Location: ../index.html");
                        exit();
                            echo 'Message has been sent';
                        }

                        //email function ends

                        
                      }
                      
                    }
                    ?>