PRODUCT: area, cuvee_domaine, capacity, vintage, alcohol_volume, price, hs_code, description, picture, status, stock_quantity, rate, created_at, updated_at
BELONGS TO1, _11 PRODUCT, 0N APPELLATION
APPELLATION : name
CONTAINED IN, 0N PRODUCT, 0N CART
CART : quantity, total_amount
IS, _11 PRODUCT, 0N COLOR
 
COLOR: name
ORDER: reference, total_quantity, total_amount, shipping_cost, tracking_number, carrier, status, created_at, updated_at
HAS RECEIVED, _11 ORDER, 0N USER: role seller
IS ORDERED, 0N PRODUCT, 1N ORDER_PRODUCT
CONTAINS, 1N ORDER, 1N ORDER_PRODUCT
HAS MADE, _11 ORDER, 0N USER: role buyer
 
ORDER_PRODUCT : order, product, quantity
SOLD BY, _11 PRODUCT, 0N USER: role seller
ADDRESS: street, zip_code, city, country, phone_number, type, firstname, lastname, province, iso
HAS, _11 ADDRESS, 1N USER
USER: role, firstname, lastname, email, password, created_at, updated_at
SELECTED BY, 01 USER, 0N CART
 
WORKS IN, 01 USER, 01 COMPANY
COMPANY : name, siret, vat, validated, presentation, rate, picture
IS SHIPPING TO, 0N COMPANY, 0N DESTINATION
DESTINATION : zone, country, iso
IS USING, 01 COMPANY, 0N PACKAGE
PACKAGE : bottle_quantity, height, length, width, weight
 
BELONGS TO2, _11 PRODUCT, 0N PRODUCT_BRAND
PRODUCT_BRAND: name, picture, selection_filter
BELONGS TO3, 1N PRODUCT, 0N PRODUCT_CATEGORY
PRODUCT_CATEGORY: name, selection_filter
OF, _11 PRODUCT, 0N TYPE
TYPE: name