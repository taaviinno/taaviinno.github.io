<?php
    // index.php
    // Prof. Jake Rodriguez Pomperada, MAED-IT, MIT
    // www.jakerpomperada.blogspot.com and www.jakerpomperada.com
    // jakerpomperada@gmail.com
    // Bacolod City, Negros Occidental
 
    // include database connection
    include "connection.php";

   
    $stmt = $con->prepare("SELECT * FROM `data` ORDER BY RAND()");
    $stmt->execute();
    $res = $stmt->get_result();
    $links = $slides = $options = $choices = "";
    if ($res->num_rows > 0) {
        $num = 0;
        while ($row = $res->fetch_assoc()) {
            $num++;
            $links .= '<a href="#slide-'.$num.'">'.$num.'</a>';
            
            $con1 = [1,2,3,4];
            shuffle($con1);
            for ($i=1; $i <= 4; $i++) { 
                $choice = "choice_".$con1[$i-1];
                ($i == 1)? $required="required":"";
                $options .= '
                            <input type="hidden" name="qid'.$num.'" value="'.$row["id"].'">
                            <label class="option option-'.$i.'">
                                <input type="radio" name="answer'.$num.'" class="optionbox" id="option-'.$num.$i.'" value="'.$row[$choice].'" '.$required.'>
                                <span>'.wordwrap($row[$choice], 25, "<br />\n").'</span>
                            </label>';
            }

            $slides .= '
                <div id="slide-'.$num.'">
                    <table>
                        <tr>
                            <td colspan="2">   
                                <div class="titleblock">Question #'.$num.'</div>
                                <textarea name="txtQuestion'.$row["id"].'" rows="5" placeholder="Enter question #'.$row["id"].' here..." disabled required>'.$row["question"].'</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="wrapper">
                                    '.$options.'
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            ';
            $options = $choices = "";
        }
    } else {
        header("Location: questions.php");
    }
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quiz | Quiz Randomizer in PHP MySQL</title>
        <link rel="stylesheet" href="styles.css">
        <style>
            .titleblock,
            table th div,
            button,
            .slider .links>a {
                background: #2196f3!important;
            }
        </style>
    </head>
    <body>
        <main>
            <form method="post" action="result.php">
                <div class="title">
                    <h1>Quiz Randomizer in PHP MySQL</h1>
                    <h2>&#187; Jake R. Pomperada, MAED-IT, MIT &#171;</h2>
                    <br>
                    <hr>
                    <h3>Quiz</h3>
                    <hr>
                </div>
                <div class="slider">
                    <div class="links">
                        <?php echo $links; ?>
                    </div>
                    <div class="slides">
                        <?php echo $slides; ?>
                    </div>

                    <button type="submit" name="btnSubmit" class="btnSubmit">Submit</button>
                </div>
            </form>
        </main>
    </body>
</html>