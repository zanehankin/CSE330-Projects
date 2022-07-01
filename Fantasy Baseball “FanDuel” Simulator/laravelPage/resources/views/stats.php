

<?php
//Credit to: https://www.educative.io/edpresso/how-to-run-python-3-script-in-laravel-7

// use Symfony\Component\Process\Process;
// use Symfony\Component\Process\Exception\ProcessFailedException;

// function testPythonScript(){
//     $process = new Process(['python', 'laravelPage/resources/views/stats.py']);
//     $process->run();

//     if(!$process->isSuccessful()){
//         // throw new ProcessFailedException($process);
//         echo("Failed you idiot");
//     }
//     $data = $process->getOutput();
//     dd($data);
// }

?>

<html>
<h1>Welcome to MLB duel</h1>
        <p>At MLB duel, baseball fans come together to create lineups and compete against other fans to get the most points. Are you a winner? Jump in to find out.</p>
        <form>
            <button onclick="location.href = '/login'">Login</button>
            <button onclick="location.href = '/register'">Register</button>
        </form>
        <!-- <a class="btn btn-primary" href="/login">Login</a>
        <a class="btn btn-primary" href="/register">Register</a> -->

</html>