*** Settings ***
Documentation     Test cases for website http://localhost:8000
Library           SeleniumLibrary
Suite Setup       Open Browser To Homepage
Suite Teardown    Close All Browsers

*** Variables ***
${URL}            http://localhost:8000
${BROWSER}        Chrome
${DELAY}          1s

*** Test Cases ***
Verify Homepage Loads Successfully
    [Documentation]    Đăng nhập
    Title Should Be    Trang chủ | Đồ án tốt nghiệp
    Page Should Contain   Đăng nhập

Test Valid Login
    [Documentation]    Test login with valid credentials
    [Tags]    login
    Click Element    link=Đăng nhập  # Thay bằng selector thực tế
    Input Text    id=email    khachhang1@gmail.com
    Input Text    id=password    123456789
    Click Button    class=btn-purple
    Wait Until Page Contains    Đăng nhập thành công
    Page Should Contain    Sản phẩm mới

Test Invalid Login
    [Documentation]    Test login with invalid credentials
    [Tags]    login
    Click Element    link=Đăng nhập
    Input Text    id=email    invalid_user@example.com
    Input Text    id=password    wrong_password
    Click Button    class=btn-purple
    Wait Until Page Contains   Email chưa được đăng ký
    Page Should Contain   Email chưa được đăng ký

Test User Registration
    [Documentation]    Test new user registration
    [Tags]    registration
    Click Element    link=Đăng ký
    Input Text    id=name    Test User
    Input Text    id=email    testuser12321@example.com
    Input Text    id=password    Test@1234
    Input Text    id=phone    0913418341
    Click Button    class=btn-purple
    Wait Until Page Contains    Đăng ký thành công
    Page Should Contain    Sản phẩm bán chạy

Test Search Functionality
    [Documentation]    Test the search feature
    [Tags]    search
    Input Text    id=search    Áo phông
    Click Button    class=btnSearch
    Wait Until Page Contains    Giá bán
    Page Should Contain    Giá dưới 50.000 vnđ

Test Navigation Menu
    [Documentation]    Test all main navigation links
    [Tags]    navigation
    @{links}=    Get WebElements    css=.avatar  # Thay bằng selector thực tế
    FOR    ${link}    IN    @{links}
        ${href}=    Get Element Attribute    ${link}    href
        Go To    ${href}
        Page Should Not Contain    Không tồn tại đường dẫn này
        Go Back
    END

*** Keywords ***
Open Browser To Homepage
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window
    Set Selenium Speed    ${DELAY}
    Title Should Be    Trang chủ | Đồ án tốt nghiệp  # Thay bằng title thực tế

Generate Random Email
    ${timestamp}=    Get Current Date    result_format=%Y%m%d%H%M%S
    [Return]    testuser+${timestamp}@example.com