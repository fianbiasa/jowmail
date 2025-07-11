<!DOCTYPE html>
<html>
<head><title>Unsubscribe</title></head>
<body>
    <h2>Unsubscribe Confirmation</h2>
    <p>Are you sure you want to unsubscribe from our list?</p>
    <form method="POST">
        @csrf
        <button type="submit">Yes, Unsubscribe</button>
    </form>
</body>
</html>