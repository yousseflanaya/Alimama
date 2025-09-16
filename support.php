<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support - AliMama</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .section-title {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'include/nav3.php'; ?>
    <div class="container py-5">
        <h1 class="text-center section-title">Customer Support</h1>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Frequently Asked Questions (FAQ)</h5>
            </div>
            <div class="card-body">
                <dl>
                    <dt>What are your shipping options?</dt>
                    <dd>We offer standard and expedited shipping. You can view shipping costs at checkout.</dd>

                    <dt>How can I return an item?</dt>
                    <dd>You can return any item within 30 days of receiving it. Please visit our returns page for more details.</dd>

                    <dt>Can I change my order after placing it?</dt>
                    <dd>Once an order is placed, it cannot be changed, but you can cancel it within 24 hours.</dd>

                    <dt>How do I track my order?</dt>
                    <dd>You will receive a tracking number once your order is shipped. You can track it through our tracking page.</dd>
                </dl>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Contact Us</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="contact_form.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Support Hours</h5>
            </div>
            <div class="card-body">
                <p>Our support team is available from Monday to Friday, 9:00 AM - 6:00 PM.</p>
                <p>If you need help outside of these hours, please send us an email, and we will get back to you as soon as possible.</p>
            </div>
        </div>

    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
