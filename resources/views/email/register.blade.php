<!DOCTYPE html>
<html>
<head>
    <title>Điện Máy Như Ý</title>
    <style>
        i {
            color: black;
        }
        p {
            color: black;
        }
        li {
            color: black;
        }
    </style>
</head>
<body>
    <p>Kính gửi: Quản trị viên {{ $details['name'] }}</p>
    <p>Trung tâm Công nghệ thông tin Điện Máy Như Ý gửi quản trị viên thông tin tài khoản để phục vụ việc quản lý hệ thống như sau: </p>
    <ul>
        <li>Email (Tên đăng nhập): <span style="color: #1155cc">{{ $details['email'] }}</span></li>
        <li>Mật khẩu: <span style="color: #1155cc">{{ $details['password'] }}</span></li>
        <li>Link đăng nhập: <a href="http://dienmay.test/admin/login">http://dienmay.test/admin/login</a></li>
    </ul>
    <i style="font-weight: bold">Ghi chú: </i>
    <i>Nếu có vướng mắc trong quá trình đăng nhập hoặc các vấn đề khác liên quan đến hệ thống vui lòng liên hệ Đỗ Lợi (0388975124) để được trợ giúp.</i>
    <p>Trân trọng!</p>
</body>
</html>