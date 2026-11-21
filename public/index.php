<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

$name = '';
$email = '';
$message = '';
$errors = [];

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = (string) ($_POST['name'] ?? '');
    $email = (string) ($_POST['email'] ?? '');
    $message = (string) ($_POST['message'] ?? '');

    if (!validate_required($name)) {
        $errors['name'] = 'Name is required.';
    } elseif (!validate_length($name, 2, 60)) {
        $errors['name'] = 'Name must be between 2 and 60 characters.';
    }

    if (!validate_email($email)) {
        $errors['email'] = 'Invalid email address.';
    }

    if (!validate_required($message)) {
        $errors['message'] = 'Message is required.';
    } elseif (!validate_length($message, 10, 1000)) {
        $errors['message'] = 'Message must be between 10 and 1000 characters.';
    }

    if (empty($errors)) {
        header('Location: index.php?success=1', true, 303);
        exit;
    }
}

$success = (
    $_SERVER['REQUEST_METHOD'] === 'GET'
    && ($_GET['success'] ?? '') === '1'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>

<body>

<h1>Contact Us</h1>

<?php if ($success): ?>

    <p>Message sent successfully!</p>
    <a href="index.php">Send another message</a>

<?php else: ?>

    <form method="post" action="index.php">

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"
               value="<?= escape($name) ?>">

        <?php if (isset($errors['name'])): ?>
            <p style="color:red;">
                <?= escape($errors['name']) ?>
            </p>
        <?php endif; ?>

        <br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"
               value="<?= escape($email) ?>">

        <?php if (isset($errors['email'])): ?>
            <p style="color:red;">
                <?= escape($errors['email']) ?>
            </p>
        <?php endif; ?>

        <br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message"
                  rows="6" cols="40"><?= escape($message) ?></textarea>

        <?php if (isset($errors['message'])): ?>
            <p style="color:red;">
                <?= escape($errors['message']) ?>
            </p>
        <?php endif; ?>

        <br><br>

        <button type="submit">Send</button>

    </form>

<?php endif; ?>

</body>
</html>