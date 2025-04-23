*** Settings ***
Documentation    Mô tả test case
Library          SeleniumLibrary

*** Variables ***
${URL}          http://localhost:8000/account/login
${BROWSER}      Chrome

*** Test Cases ***
Kiểm thử đăng nhập thành công
    [Documentation]    Kiểm tra chức năng đăng nhập với thông tin hợp lệ
    Mở trình duyệt và truy cập trang web
    Nhập thông tin đăng nhập    user@example.com    password123
    Kiểm tra đăng nhập thành công
    Đóng trình duyệt

*** Keywords ***
Mở trình duyệt và truy cập trang web
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window

Nhập thông tin đăng nhập
    [Arguments]   ${name}       ${password}
    Input Text    id=name       khachhang1@gmail.com
    Input Text    id=password      123456789
    Click Button    class=btn-purple

Kiểm tra đăng nhập thành công
    Wait Until Page Contains    Sản phẩm bán chạy
    Page Should Contain    Sản phẩm mới

Đóng trình duyệt
    Close Browser