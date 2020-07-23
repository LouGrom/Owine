ADDRESS: type, firstname, lastname, street, zip_code, city, province, country, iso, phone_number, created_at, updated_at
:
ORDER: company, reference, total_quantity, total_amount, shipping_cost, tracking_number, created_at, updated_at
IS DELIVERED BY, 01 ORDER, 0N CARRIER
 
HAS2, _11 ADDRESS, 1N USER
HAS RECEIVED, _11 ORDER, 0N USER: role seller
CONTAINS, 1N ORDER, 1N ORDER_PRODUCT
 
USER: role, firstname, lastname, email, password, created_at, updated_at
HAS MADE, _11 ORDER, 0N USER: role buyer
ORDER_PRODUCT : order_id, product_id, quantity
COMPANY : name, SIRET, VAT, presentation, rate, products
 
SELECTED BY, 01 USER, 0N CART
SOLD BY, _11 PRODUCT, 0N USER: role seller
IS ORDERED, 0N PRODUCT, 1N ORDER_PRODUCT
WORKS IN, 01 USER, 01 COMPANY
 
CART : quantity, amount
CONTAINED IN, 0N PRODUCT, 0N CART
PRODUCT: company, area, cuvée/domaine, capacity, vintage, alcohol volume, price, hs code, description, picture, status, stock_quantity, rate, created at, updated at
COLOR: name
 
:
BELONGS TO1, 1N PRODUCT, 0N PRODUCT_CATEGORY
BELONGS TO2, _11 PRODUCT, 0N PRODUCT_BRAND
IS, _11 PRODUCT, 0N COLOR
 
:
PRODUCT_CATEGORY: name, selection_filter
PRODUCT_BRAND: name, picture, selection_filter
OF, _11 PRODUCT, 0N TYPE
 
APPELLATION : name
BELONGS TO3, _11 PRODUCT, 0N APPELLATION
 
:::
TYPE: name
 
DESTINATION : zone, country, iso
IS SHIPPING TO, 0N COMPANY, 0N DESTINATION
PACKAGE : boxSize, height, length, width, weight, selected
IS USING, 01 COMPANY, 0N PACKAGE
 
 
ADDRESS ( role, type, firstname, lastname, street, zip_code, city, province, country, phone_number, created_at, updated_at )
ORDER ( role, role.1, company, reference, total_quantity, total_amount, shipping_cost, tracking_number, created_at, updated_at, name, role seller, role buyer )
CONTAINS ( role, role.1, company, order_id )
CARRIER ( name, mode )
USER ( role, firstname, lastname, email, password, created_at, updated_at, name, quantity )
ORDER_PRODUCT ( order_id, product_id, quantity )
COMPANY ( name, SIRET, VAT, presentation, rate, products, boxSize )
IS ORDERED ( name, name.1, name.2, role, name.3, company, order_id )
CART ( quantity, amount )
CONTAINED IN ( name, name.1, name.2, role, name.3, company, quantity )
PRODUCT ( name, name.1, name.2, role, name.3, company, area, cuvée/domaine, capacity, vintage, alcohol volume, price, hs code, description, picture, status, stock_quantity, rate, created at, updated at, role seller )
BELONGS TO ( name, name.1, name.2, role, name.3, company, name.4 )
PRODUCT_CATEGORY ( name, selection_filter )
PRODUCT_BRAND ( name, picture, selection_filter )
DESTINATION ( zone, country, iso )
IS SHIPPING TO ( name, zone )
PACKAGE ( boxSize, height, length, width, weight, selected )