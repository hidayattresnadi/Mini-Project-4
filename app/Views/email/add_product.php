<!DOCTYPE html>
<html>

<head>
    <title>Product Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        h2 {
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>A new product has been successfully added</p>

        <div style="text-align: center; margin-bottom: 15px;">
            <img src="<?= $thumbnail ?>" alt="Product Thumbnail" style="max-width: 150px; border-radius: 5px; border: 1px solid #ddd;">
        </div>

        <table style="width:100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td><strong>Product ID:</strong></td>
                <td><?= $product_id ?></td>
            </tr>
            <tr>
                <td><strong>Product Name:</strong></td>
                <td><?= $product->name ?></td>
            </tr>
            <tr>
                <td><strong>Description:</strong></td>
                <td><?= $product->description ?></td>
            </tr>
            <tr>
                <td><strong>Category:</strong></td>
                <td><?= $category->name ?></td>
            </tr>
            <tr>
                <td><strong>Price:</strong></td>
                <td>Rp<?= number_format($product->price, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td><strong>Stock Quantity:</strong></td>
                <td><?= $product->stock ?></td>
            </tr>
            <tr>
                <td><strong>Added Date:</strong></td>
                <td><?= $registration_date ?></td>
            </tr>
        </table>

        <p>You can view this product in the system by clicking the button below:</p>

        <a href="<?= $product_url ?>" style="display: inline-block; background-color: #007bff; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 5px;">View Product</a>

        <p>Thank you!</p>

        <div class="footer">
            <p>Best Regards, <br> Online App</p>
        </div>
    </div>

</body>

</html>