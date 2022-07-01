<!DOCTYPE html>
<html lang = "en">
    <head>
    <title>Calculator!</title>
    </head>

    <body>
        <form method = "POST" action = "/~zane/module2-individual-zanehankin/Calculator.php" >
            <p>
                <label for = "num1">First Number:</label>
                <input type = "text" name = "num1" id = "num1"/>
            </p>

            <p>
                <label for = "num2">Second Number:</label>
                <input type = "text" name = "num2" id = "num2"/>
            </p>

            <p>
            <input type = "radio" name = "op" value = "+" id = "add"/>
            <label for = "add">+</label>
            </p>
            <p>
            <input type = "radio" name = "op" value = "-" id = "sub"/>
            <label for = "sub">-</label>
            </p>
            <p>
            <input type = "radio" name = "op" value = "*" id = "mult"/>
            <label for = "mult">*</label>
            </p>
            <p>
            <input type = "radio" name = "op" value = "/" id = "div"/>
            <label for = "div">÷</label>
            </p>

            <p>
                <input type = "submit" value = "Send"/>
                <input type = "reset"/>
            </p>

            <?php
                $num1 = $_POST['num1'];
                $num2 = $_POST['num2'];
                $op = $_POST['op'];
                htmlentities($op);
                if(strcmp($op, "+") == 0){
                    echo($num1 . " " . $op . " " . $num2 . " = "); 
                    echo($num1 + $num2);
                }
                if(strcmp($op, "-") == 0){
                    echo($num1 . " " . $op . " " . $num2 . " = "); 
                    echo($num1 - $num2);
                }
                if(strcmp($op, "*") == 0){
                    echo($num1 . " " . $op . " " . $num2 . " = "); 
                    echo($num1 * $num2);
                }
                if(strcmp($op, "/") == 0){
                    if($num2 == 0){
                        echo("Cannot divide by 0.");
                    }
                    else{
                        echo($num1 . " " . $op . " " . $num2 . " = "); 
                        echo($num1 / $num2);
                    }
                }
            ?>
            <p>

            </p>

        </form>
    </body>
</html>