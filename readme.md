## Module Name : Levelshoes_Shopfinder

### Installation Steps
1. Copy the whole code base under app/code/`Levelshoes/Shopfinder`
 <br> OR
2. Using composer : composer require krunal/module-shopfinder

### After performing above step please run below commands  

```
php bin/magento module:enable Levelshoes_Shopfinder
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```

#### GraphQL API Request Example
URL : storeurl/graphql

1. List all Shop <br> Choose the fields which you want to list in API Response

```query {
  ListShopsGraphql {
    shopname
    identifier
    addresslineone
    addresslinetwo
    city
    country
    state
    zipcode
    phone
    latitude
    longitude
    email
    shopimage
    status
    cancollect
    shopdescription
    shopopentimedetail
    storeview
  }
}
```
2. Get Shop by shop_id

```
query {
  ListShopsByStoreIDGraphql(shop_id:2) {
    shopname
    identifier
  }
}
```

3. Update Shop by shopid

```
mutation {
  editShopData(shop_id: 1, shopname: "test shop", status: 1, state: 0) {
    status
    message
  }
}
```
NOTE : Flag detail

```
Enabled : 1
Disabled : 0
```
