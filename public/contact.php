<?php include './includes/header.php'; ?>

<h1 class="text-3xl font-bold">Contact Us</h1>
<form action="contact.php" method="POST" class="bg-white p-6 rounded shadow-md w-1/2">
    <label class="block mb-2">Name:</label>
    <input type="text" name="name" class="border p-2 w-full mb-4">

    <label class="block mb-2">Message:</label>
    <textarea name="message" class="border p-2 w-full mb-4"></textarea>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Send</button>
</form>

<?php include './includes/footer.php'; ?>
