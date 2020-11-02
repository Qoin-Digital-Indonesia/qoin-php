# Qoin-PHP

## Install via Composer
`composer require qoin/qoin-php`

## Usage
### 1. BRI VA
#### a. Create Order
```
(new \Qoin\BriVa)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->createOrder([
        'MerchantNumber' => '<your merchant code>',
        'ReferenceNumber' => '<reference number>',
        'Amount' => 21000,
        'Currency' => 'IDR',
        'Description' => json_encode([
            ['Item' => 1, 'Desc' => 'T-Shirt', 'Amount' => 15000],
            ['Item' => 2, 'Desc' => 'Admin', 'Amount' => 5000],
            ['Item' => 3, 'Desc' => 'Shipping', 'Amount' => 1000],
        ]), // format: JSON string
        'UserName' => 'Giovanni Reinard',
        'UserContact' => '628123456789;giovanni@loyalto.id', // format: phone_number;email_address
        'RequestTime' => date(DateTime::ISO8601)
    ]);
```
#### b. Get Status
```
(new \Qoin\BriVa)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->getStatus([
        'OrderNumber' => '<order number>',
        'ReqTime' => date(DateTime::ISO8601)
    ]);
```

### 2. Credit Card
#### a. Create Order
```
(new \Qoin\CreditCard)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->createOrder([
        'reference_no' => '<reference number>',
        'account_number' => '4000000000000002',
        'exp_month' => '12',
        'exp_year' => '2020',
        'card_cvn' => '123',
        'amount' => 25000,
        'request_time' => date('Y-m-d H:i:s'),
        'merchant_code' => '<your merchant code>'
    ]);
```
#### b. Charge
```
(new \Qoin\CreditCard)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->charge([
        'order_no' => '<order number>'
    ]);
```
#### c. Get Status
```
(new \Qoin\CreditCard)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->setReferenceNumber('<reference number>')
    ->getStatus([
        'MerchantCode' => '<your merchant code>',
        'OrderNo' => '<order number>',
        'ReqTime' => date('Y-m-d H:i:s')
    ]);
```

### 3. OVO
#### a. Create Order
```
(new \Qoin\Ovo)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->createOrder([
        'Amount' => 10,
        'Currency' => 'IDR',
        'Description' => json_encode([
            ['Item' => 1, 'Desc' => 'T-Shirt', 'Amount' => 15000],
            ['Item' => 2, 'Desc' => 'Admin', 'Amount' => 5000],
            ['Item' => 3, 'Desc' => 'Shipping', 'Amount' => 1000],
        ]), // format: JSON string,
        'ReqTime' => date('Y-m-d H:i:s'),
        'MerchantCode' => '<your merchant code>',
        'ReferenceNo' => '<reference number>',
        'CustomerName' => 'Giovanni Reinard',
        'CustomerPhone' => '08123456789',
        'CustomerEmail' => 'giovanni@loyalto.id'
    ]);
```
#### b. Get Status
```
(new \Qoin\Ovo)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->getStatus([
        'RequestTime' => date('Y-m-d H:i:s'),
        'MerchantCode' => '<your merchant code>',
        'ReferenceNo' => '<reference number>'
    ]);
```

### 4. LinkAja
#### a. Create Order
```
(new \Qoin\LinkAja)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->createOrder([
        'Amount' => 10,
        'Currency' => 'IDR',
        'Description' => json_encode([
            ['Item' => 1, 'Desc' => 'T-Shirt', 'Amount' => 15000],
            ['Item' => 2, 'Desc' => 'Admin', 'Amount' => 5000],
            ['Item' => 3, 'Desc' => 'Shipping', 'Amount' => 1000],
        ]), // format: JSON string,
        'ReqTime' => date('Y-m-d H:i:s'),
        'MerchantCode' => '<your merchant code>',
        'ReferenceNo' => '<reference number>',
        'CustomerName' => 'Giovanni Reinard',
        'CustomerPhone' => '08123456789',
        'CustomerEmail' => 'giovanni@loyalto.id'
    ]);
```
#### b. Get Status
```
(new \Qoin\LinkAja)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->getStatus([
        'RequestTime' => date('Y-m-d H:i:s'),
        'MerchantCode' => '<your merchant code>',
        'ReferenceNo' => '<reference number>'
    ]);
```

### 5. Snap
#### - Create Order
```
(new \Qoin\Snap)
    ->setEnvironment('sandbox') // sandbox || production
    ->setPrivateKey('<your private key>')
    ->setSecretKey('<your secret key>')
    ->createOrder([
        'merchantCode' => '<your merchant code>',
        'linkPayment' => '12345',
        'referenceNo' => '<reference number>',
        'expiredDate' => '',
        'requestTime' => date('Y-m-d H:i:s'),
        'currency' => 'IDR',
        'paymentMethod' => '',
        'paymentChannel' => '',
        'customerName' => 'Giovanni Reinard',
        'customerPhone' => '628123456789',
        'customerEmail' => 'giovanni@loyalto.id',
        'product' => [
            ['Item' => 1, 'Desc' => 'T-Shirt', 'Amount' => 15000],
            ['Item' => 2, 'Desc' => 'Admin', 'Amount' => 5000],
            ['Item' => 3, 'Desc' => 'Shipping', 'Amount' => 1000],
        ], // format: array
        'totalPrice' => 21000
    ]);
```
