<!DOCTYPE html>
<html>
<head>
    <title>Donate - Mini Tabungan</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav>
        <h1>Mini Tabungan</h1>
        <a href="home">Home</a>
    </nav>

    <main>
        <h2>Make a Saving</h2>
        <form method="POST" action="save">
            <div>
                <label>Amount (Rp)</label>
                <input type="number" name="amount" required>
            </div>
            <div>
                <label>Message</label>
                <textarea name="message" required></textarea>
            </div>
            <button type="submit">Save</button>
        </form>
    </main>
</body>
</html>