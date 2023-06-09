<?php
     // Prof. Jake Rodriguez Pomperada, MAED-IT, MIT
    // www.jakerpomperada.blogspot.com and www.jakerpomperada.com
    // jakerpomperada@gmail.com
    // Bacolod City, Negros Occidental
    // include database connection

    include "connection.php";
    $key = [];
    $num = 0;
    if(isset($_POST["btnSubmit"])) {
        for ($i=1; $i < 5; $i++) { 
            $stmt = $con->prepare("SELECT * FROM `data` WHERE `id`=?");
            $stmt->bind_param("i", $_POST["qid".$i]);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()){
                for ($x=1; $x < 5; $x++) {
                    if ($_POST["answer".$i] == $row["choice_".$x]) {
                        ($row["answer"] == $x)? $num++:"";
                    }
                }
            }
            $stmt->close();
        }
    }
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Result | Quiz Randomizer in PHP MySQL</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <main>
            <div class="title">
                <h1>Quiz Randomizer in PHP MySQL</h1>
                <h2>&#187; Jake R. Pomperada, MAED-IT, MIT &#171;</h2>
                <br>

                <hr>
                <h3>Result</h3>
                <hr>

                <h1 class="txtScore">Score: <?php echo ($num*25)."%"; ?></h1>

                <div class="btnWrapper">
                    <a href="questions.php" class="btnHalf btnSubmit">Back to Questions</a>
                    <a href="index.php" class="btnHalf btnQuiz">Take the Quiz Again?</a>
                </div>
            </div>
        </main>
    </body>
</html>