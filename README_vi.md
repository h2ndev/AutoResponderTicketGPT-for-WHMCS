# AutoResponderGPT for WHMCS

[Read this in English](/README.md)

## Mô tả

Dự án này là một addon cho WHMCS, tự động phản hồi các ticket mới bằng cách sử dụng API ChatGPT. Addon này lấy nội dung và tiêu đề của ticket mới, gửi chúng đến ChatGPT API để tạo câu trả lời kết hợp với thông tin prompt của người dùng trong config addon, và sau đó phản hồi lại ticket dưới tư cách là admin.

![Demo](https://i.imgur.com/jm8fGpG.png)

## Tính năng

- Tự động trả lời ticket mới
- Sử dụng OpenAI ChatGPT để tạo câu trả lời
- Thêm chữ ký vào cuối mỗi câu trả lời để thông báo rằng câu trả lời được tạo tự động

## Cài đặt

### Yêu cầu

- WHMCS
- PHP 7.4 trở lên
- cURL PHP extension

### Hướng dẫn cài đặt

1. **Clone repository**:

   ```bash
   git clone https://github.com/h2ndev/AutoResponderTicketGPT-for-WHMCS.git
   cd AutoResponderTicketGPT-for-WHMCS
   ```

2. **Sao chép mã vào thư mục WHMCS**:

   Sao chép các tệp từ repository vào thư mục WHMCS của bạn, cụ thể là thư mục `modules/addons/autorespondergpt`.

3. **Cấu hình addon**:

   - Đăng nhập vào WHMCS Admin.
   - Điều hướng đến `Addons` > `Addon Modules`.
   - Tìm `AutoResponderGPT` và nhấp vào `Activate`.
   - Nhấp vào `Configure` và nhập OpenAI API Key và admin username.
   ![Demo](https://i.imgur.com/8FISzOz.png)

## Sử dụng (Tự Động)

1. Khi một ticket mới được tạo, addon sẽ tự động lấy nội dung và tiêu đề của ticket.
2. Addon sẽ gửi yêu cầu đến ChatGPT API để tạo câu trả lời.
3. Câu trả lời sẽ được gửi lại cho ticket cùng với chữ ký thông báo rằng câu trả lời được tạo tự động.
