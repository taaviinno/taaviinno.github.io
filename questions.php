<?php
   // Prof. Jake Rodriguez Pomperada, MAED-IT, MIT
    // www.jakerpomperada.blogspot.com and www.jakerpomperada.com
    // jakerpomperada@gmail.com
    // Bacolod City, Negros Occidental
    // include database connection

    include "connection.php";
    $message = "";

    if(isset($_POST["btnSubmit"])) {
        for ($i=1; $i < 5; $i++) { 
            $qn = "txtQuestion".$i;
            $c1 = "txtChoice".$i."1";
            $c2 = "txtChoice".$i."2";
            $c3 = "txtChoice".$i."3";
            $c4 = "txtChoice".$i."4";
            $ans = "txtAnswer".$i;
            $stmt_check = $con->prepare("SELECT `id` FROM `data` WHERE `id`=?");
            $stmt_check->bind_param("i", $i);
            $stmt_check->execute();
            $stmt_check->store_result();
            if($stmt_check->num_rows > 0) {
                $stmt = $con->prepare("UPDATE `data` SET `question`=?,`choice_1`=?,`choice_2`=?,`choice_3`=?,`choice_4`=?,`answer`=? WHERE `id`=?");
                $stmt->bind_param("sssssii", $_POST[$qn], $_POST[$c1], $_POST[$c2], $_POST[$c3], $_POST[$c4], $_POST[$ans], $i);
                $message = '<div class="message update">Record Successfully Updated</div>';
            } else {
                $stmt = $con->prepare("INSERT INTO `data`(`question`, `choice_1`, `choice_2`, `choice_3`, `choice_4`, `answer`) VALUES (?,?,?,?,?,?)");
                $stmt->bind_param("sssssi", $_POST[$qn], $_POST[$c1], $_POST[$c2], $_POST[$c3], $_POST[$c4], $_POST[$ans]);
                $message = '<div class="message save">Record Successfully Saved</div>';
            }
            $stmt->execute();
            $stmt->close();
        }
    }

    $stmt = $con->prepare("SELECT * FROM `data`");
    $stmt->execute();
    $res = $stmt->get_result();
    $links = $slides = $options = $choices = "";
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            for ($i=1; $i <= 4; $i++) { 
                $i == $row["answer"]? $selected ="selected": $selected = ""; 
                $options .= '<option value="'.$i.'" '.$selected.'>Choice #'.$i.'</option>';
                $choice = "choice_".$i;
                $choices .= '<tr>
                                <th><div>Choice #'.$i.':</div></th>
                                <td><input type="text" name="txtChoice'.$row["id"].$i.'" placeholder="Enter choice #'.$i.' here..." value="'.$row[$choice].'" required></td>
                            </tr>';
            }

            $links .= '<a href="#slide-'.$row["id"].'">'.$row["id"].'</a>';

            $slides .= '
                <div id="slide-'.$row["id"].'">
                    <table>
                        <tr>
                            <td colspan="2">   
                                <div class="titleblock">Question #'.$row["id"].'</div>
                                <textarea name="txtQuestion'.$row["id"].'" rows="5" placeholder="Enter question #'.$row["id"].' here..." required>'.$row["question"].'</textarea>
                            </td>
                        </tr>
                        '.$choices.'
                        <tr>
                            <th><div>Answer:</div></th>
                            <td>
                                <select name="txtAnswer'.$row["id"].'" required>
                                    '.$options.'
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            ';
            $options = $choices = "";
        }
    } else {
        $message = '<div class="message error"><b>ERROR:</b> No Questions to display. Please add some questions first.</div>';

        for ($reps=1; $reps < 5; $reps++) {
            $links .= '<a href="#slide-'.$reps.'">'.$reps.'</a>';

            for ($i=1; $i <= 4; $i++) { 
                $options .= '<option value="'.$i.'">Choice #'.$i.'</option>';
                $choice   = "choice_".$i;
                $choices .= '<tr>
                                <th><div>Choice #'.$i.':</div></th>
                                <td><input type="text" name="txtChoice'.$reps.$i.'" placeholder="Enter choice #'.$i.' here..." required></td>
                            </tr>';
            }

            $slides .= '
                <div id="slide-'.$reps.'">
                    <table>
                        <tr>
                            <td colspan="2">   
                                <div class="titleblock">Question #'.$reps.'</div>
                                <textarea name="txtQuestion'.$reps.'" rows="5" placeholder="Enter question #'.$reps.' here..." required></textarea>
                            </td>
                        </tr>
                        '.$choices.'
                        <tr>
                            <th><div>Answer:</div></th>
                            <td>
                                <select name="txtAnswer'.$reps.'" required>
                                    <option value="" selected disabled>~ Select Answer ~</option>
                                    '.$options.'
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            ';
            $options = $choices = "";
        }
    }
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Questions | Quiz Randomizer in PHP MySQL</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php echo $message; ?>
        <main>
            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                <div class="title">
                    <h1>Quiz Randomizer in PHP MySQL</h1>
                    <h2>&#187; Jake R. Pomperada, MAED-IT, MIT &#171;</h2>
                    <br>
                    <hr>
                    <h3>Questions</h3>
                    <hr>
                </div>
                <div class="slider">
                    <div class="links">
                        <?php echo $links; ?>
                    </div>
                    <div class="slides">
                        <?php echo $slides; ?>
                    </div>
                    <div class="btnWrapper">
                        <button type="submit" name="btnSubmit" class="btnHalf btnSubmit">Save Entries</button>
                        <a href="index.php" class="btnHalf btnQuiz">Take the Quiz!</a>
                    </div>
                </div>
            </form>
        </main>
    </body>
</html>