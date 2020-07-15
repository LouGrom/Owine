IS DELIVERED BY, 01 ORDER, 0N CARRIER
CARRIER: name, mode
COMPANY : name, SIRET, VAT, presentation, rate
WORKS IN, 01 USER, 01 COMPANY
COLOR: name
IS, _11 PRODUCT, 0N COLOR
OF, _11 PRODUCT, 0N TYPE
:
TYPE: name
IS USING, 01 COMPANY, 0N PACKAGE

ORDER: reference, total_quantity, total_amount, tracking_number, created_at, updated_at
CONTAINS, 1N ORDER, 1N ORDER_PRODUCT
ORDER_PRODUCT : order_id, product_id,quantity
IS ORDERED, 0N PRODUCT, 1N ORDER_PRODUCT
PRODUCT: area, cuvée/domaine, capacity, vintage, alcohol volume, price, hs code, description, picture, status, stock_quantity, rate, created at, updated at
BELONGS TO2, _11 PRODUCT, 0N PRODUCT_BRAND
PRODUCT_BRAND: name, picture, selection_filter
BELONGS TO3, _11 PRODUCT, 0N APPELLATION
:
PACKAGE : selected, boxSize, height, length, width, weight

:
HAS RECEIVED, _11 ORDER, 0N USER: role seller
HAS MADE, _11 ORDER, 0N USER: role buyer
SOLD BY, _11 PRODUCT, 0N USER: role seller
CONTAINED IN, 0N PRODUCT, 0N CART
BELONGS TO1, 1N PRODUCT, 0N PRODUCT_CATEGORY
PRODUCT_CATEGORY: name, selection_filter
APPELLATION : name
:
IS SHIPPING TO, 01 COMPANY, 0N DESTINATION

ADDRESS: type, firstname, lastname, street, zip_code, city, province, country, phone_number, created_at, updated_at
HAS2, _11 ADDRESS, 1N USER
USER: role, firstname, lastname, email, password, created_at, updated_at
SELECTED BY, 01 USER, 0N CART
CART : quantity, total_amount
::::
DESTINATION : zone, country