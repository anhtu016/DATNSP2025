<!-- Favicons-->
<link rel="shortcut icon" href="{{ asset('client/img/favicon.ico') }}" type="image/x-icon">
<link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('client/img/apple-touch-icon-57x57-precomposed.png') }}">
<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
    href="{{ asset('client/img/apple-touch-icon-72x72-precomposed.png') }}">
<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
    href="{{ asset('client/img/apple-touch-icon-114x114-precomposed.png') }}">
<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
    href="{{ asset('client/img/apple-touch-icon-144x144-precomposed.png') }}">

<!-- GOOGLE WEB FONT -->
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&amp;display=swap" rel="stylesheet">

<!-- BASE CSS -->
<link rel="preload" href="{{ asset('client/css/bootstrap.min.css') }}" as="style">
<link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}">
<link href="{{ asset('client/css/style.css') }}" rel="stylesheet">

<!-- YOUR CUSTOM CSS -->
<link href="{{ asset('client/css/custom.css') }}" rel="stylesheet">
<style>
    /* trang chủ */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .main {
        flex: 1;
        /* Chiếm phần còn lại, đẩy footer xuống dưới */
    }

    /* trang chi tiết */
    .color-swatch {
        width: 40px;
        height: 40px;
        border: 2px solid #ccc;
        border-radius: 6px;
        padding: 0;
        display: inline-block;
    }

    .btn-check:checked+.color-swatch {
        border: 3px solid #000;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    .btn-check:checked+.btn-outline-dark {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }
/* trang giỏ hàng */
        .cart-table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-top: 30px;
            overflow-x: auto;
        }

        table.cart-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            min-width: 800px;
        }

        .cart-table thead {
            background-color: #f9fafb;
        }

        .cart-table th,
        .cart-table td {
            padding: 15px 12px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0;
        }

        .cart-table img {
            max-width: 60px;
            border-radius: 6px;
        }

        .cart-table td form input[type="number"] {
            width: 65px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-align: center;
        }

        .cart-actions {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .cart-actions .btn {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 6px;
        }

        .btn-success {
            background-color: #10b981;
            border: none;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-danger {
            background-color: #ef4444;
            border: none;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-primary {
            background-color: #3b82f6;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            color: white;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .total-price {
            margin-top: 20px;
            font-weight: bold;
            font-size: 18px;
            color: #111827;
        }

        @media (max-width: 768px) {
            .cart-table-container {
                padding: 15px;
            }

            .btn-primary {
                width: 100%;
                text-align: center;
            }
        }
       /* đặt hàng */
            .checkout-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                padding: 30px;
                gap: 30px;
                font-family: 'Segoe UI', sans-serif;
                background-color: #f5f7fa;
            }
        
            .card {
                background: white;
                border-radius: 10px;
                padding: 25px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.05);
                flex: 1 1 45%;
            }
        
            .card h2 {
                margin-bottom: 20px;
                color: #333;
                font-size: 22px;
            }
        
            .form-group {
                margin-bottom: 15px;
            }
        
            label {
                display: block;
                font-weight: 600;
                margin-bottom: 5px;
            }
        
            input[type="text"],
            select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 15px;
            }
        
            input[readonly] {
                background-color: #f0f0f0;
            }
        
            .error {
                color: red;
                font-size: 13px;
            }
        
            .success {
                color: green;
                font-weight: bold;
                margin-bottom: 10px;
            }
        
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }
        
            th, td {
                border-bottom: 1px solid #ddd;
                padding: 10px;
                text-align: center;
            }
        
            img {
                max-width: 50px;
                border-radius: 5px;
            }
        
            button {
                background-color: #3b82f6;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 8px;
                font-size: 16px;
                cursor: pointer;
                margin-top: 10px;
                transition: background-color 0.3s ease;
            }
        
            button:hover {
                background-color: #2563eb;
            }
        
            @media (max-width: 768px) {
                .checkout-container {
                    flex-direction: column;
                }
            }
        </style>
