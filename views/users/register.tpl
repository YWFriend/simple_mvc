<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo $title; ?></title>
</head>
<body>

    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>

    <h1><?php echo $title; ?></h1>

    <?php
        if (isset($errors))
        {
            echo '<ul>';
            foreach ($errors as $e)
            {
                echo '<li>' . $e . '</li>';
            }
            echo '</ul>';
        }

        if (isset($saveError))
        {
            echo "<h2>Error saving data. Please try again.</h2>" . $saveError;
        }
    ?>

    <form action="/users/save" method="post">
        <p>
            <label for="name">Username:</label>
            <input value="<?php if(isset($formData)) echo $formData['name']; ?>" type="text" id="name" name="name" require/>
        </p>

        <p>
            <label for="password">Password:</label>
            <input value="<?php if(isset($formData)) echo $formData['password']; ?>" type="text" id="password" name="password" require/>
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input value="<?php if(isset($formData)) echo $formData['email']; ?>" type="text" id="email" name="email" require/>
        </p>

        <p>
            <label for="isAdmin">Is admin:</label>
            <input value="<?php if(isset($formData)) echo $formData['isAdmin']; ?>" type="text" id="isAdmin" name="isAdmin" require/>
        </p>

        <input type="submit" name="userFormSubmit" value="Send" />
    </form>

</body>
</html>