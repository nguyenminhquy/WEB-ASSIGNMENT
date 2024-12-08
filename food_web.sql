-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 05:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(68, 27, 2, 1, '2024-12-06 12:42:00'),
(91, 11, 2, 2, '2024-12-08 12:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_name`, `comment_text`, `created_at`) VALUES
(1, 5, 'nguyenminhquy', 'rat la ngon lun nha moi nguoi oi \r\n', '2024-12-06 11:50:16'),
(2, 5, 'nguyenminhquy', 'rat la ngon lun nha moi nguoi oi \r\n', '2024-12-06 11:50:34'),
(9, 2, 'quy.nguyen050104', 'rát ngon nha ', '2024-12-08 14:23:01'),
(10, 3, 'quy.nguyen050104', 'phở ngon và cừa mienfhbee', '2024-12-08 14:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `payment_method`, `order_date`, `status`) VALUES
(1, 11, 405000.00, 'cash', '2024-12-02 16:26:47', 'Completed'),
(2, 11, 105000.00, 'cash', '2024-12-02 16:32:08', 'Cancelled'),
(3, 11, 105000.00, 'cash', '2024-12-02 16:36:27', 'Completed'),
(4, 11, 105000.00, 'cash', '2024-12-02 16:40:03', 'Cancelled'),
(5, 11, 105000.00, 'cash', '2024-12-02 16:41:37', 'Pending'),
(6, 11, 105000.00, 'cash', '2024-12-02 16:44:41', 'Cancelled'),
(7, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:01:07', 'Pending'),
(8, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:01:31', 'Pending'),
(9, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:01:31', 'Completed'),
(10, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:01:32', 'Pending'),
(11, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:01:32', 'Completed'),
(12, 11, 105000.00, 'cash', '2024-12-02 17:01:57', 'Pending'),
(13, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:02:20', 'Pending'),
(14, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:03:19', 'Pending'),
(15, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:03:20', 'Pending'),
(16, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:03:20', 'Cancelled'),
(17, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:03:20', 'Pending'),
(18, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:03:21', 'Pending'),
(19, 11, 105000.00, 'Chưa thanh toán', '2024-12-02 17:03:21', 'Completed'),
(20, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:06:05', 'Completed'),
(21, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:06:22', 'Cancelled'),
(22, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:06:23', 'Pending'),
(23, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:06:23', 'Cancelled'),
(24, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:06:23', 'Pending'),
(25, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:06:23', 'Pending'),
(26, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:06:25', 'Pending'),
(27, 11, 165000.00, 'Chưa thanh toán', '2024-12-02 17:13:41', 'Pending'),
(28, 11, 525000.00, 'cash', '2024-12-02 17:42:16', 'Pending'),
(29, 11, 155000.00, 'credit_card', '2024-12-02 18:15:17', 'Pending'),
(30, 11, 45000.00, 'cash', '2024-12-03 01:27:14', 'Pending'),
(31, 11, 105000.00, 'cash', '2024-12-03 07:25:42', 'Pending'),
(32, 11, 225000.00, 'cash', '2024-12-03 16:47:12', 'Pending'),
(33, 11, 60000.00, 'cash', '2024-12-03 19:37:09', 'Pending'),
(34, 11, 1840000.00, 'cash', '2024-12-04 16:04:26', 'Pending'),
(35, 11, 60000.00, 'cash', '2024-12-04 16:47:23', 'Pending'),
(36, 11, 885000.00, 'cash', '2024-12-04 17:50:42', 'Pending'),
(37, 11, 60000.00, 'cash', '2024-12-04 17:53:24', 'Pending'),
(38, 11, 45000.00, 'cash', '2024-12-04 17:54:37', 'Pending'),
(39, 11, 105000.00, 'cash', '2024-12-04 18:05:38', 'Pending'),
(40, 11, 60000.00, 'cash', '2024-12-04 18:07:17', 'Pending'),
(41, 11, 50000.00, 'cash', '2024-12-04 18:10:14', 'Pending'),
(42, 11, 60000.00, 'cash', '2024-12-04 18:11:12', 'Pending'),
(43, 11, 60000.00, 'cash', '2024-12-04 18:11:48', 'Pending'),
(44, 11, 50000.00, 'cash', '2024-12-04 18:12:54', 'Pending'),
(45, 11, 60000.00, 'cash', '2024-12-04 18:13:35', 'Pending'),
(46, 11, 120000.00, 'cash', '2024-12-04 18:14:37', 'Pending'),
(47, 11, 60000.00, 'cash', '2024-12-04 18:16:13', 'Pending'),
(48, 11, 60000.00, 'cash', '2024-12-04 18:17:35', 'Pending'),
(49, 11, 60000.00, 'cash', '2024-12-04 18:18:04', 'Pending'),
(50, 11, 60000.00, 'credit_card', '2024-12-05 05:24:36', 'Pending'),
(51, 11, 150000.00, 'cash', '2024-12-05 10:26:40', 'Pending'),
(52, 11, 120000.00, 'cash', '2024-12-06 03:23:26', 'Pending'),
(53, 11, 2730000.00, 'cash', '2024-12-06 04:12:37', 'Pending'),
(54, 11, 60000.00, 'bank_transfer', '2024-12-06 04:42:49', 'Pending'),
(55, 11, 70000.00, 'bank_transfer', '2024-12-06 04:47:40', 'Pending'),
(56, 11, 60000.00, 'bank_transfer', '2024-12-06 07:32:52', 'Pending'),
(57, 11, 60000.00, 'cash', '2024-12-06 07:34:54', 'Pending'),
(58, 11, 60000.00, 'cash', '2024-12-06 07:35:25', 'Pending'),
(59, 11, 60000.00, 'cash', '2024-12-06 07:36:58', 'Pending'),
(60, 11, 60000.00, 'cash', '2024-12-06 07:37:30', 'Pending'),
(61, 11, 60000.00, 'cash', '2024-12-06 07:37:55', 'Pending'),
(62, 11, 60000.00, 'cash', '2024-12-06 07:38:44', 'Pending'),
(63, 11, 60000.00, 'cash', '2024-12-06 07:38:59', 'Pending'),
(64, 11, 165000.00, 'bank_transfer', '2024-12-06 12:49:35', 'Pending'),
(65, 11, 60000.00, 'bank_transfer', '2024-12-06 12:53:55', 'Pending'),
(66, 11, 180000.00, 'cash', '2024-12-06 17:12:28', 'Pending'),
(67, 11, 360000.00, 'cash', '2024-12-06 17:27:26', 'Pending'),
(68, 11, 840000.00, 'cash', '2024-12-06 17:30:40', 'Pending'),
(69, 11, 120000.00, 'cash', '2024-12-06 20:11:26', 'Pending'),
(70, 11, 135000.00, 'bank_transfer', '2024-12-07 03:34:00', 'Pending'),
(71, 11, 210000.00, 'cash', '2024-12-07 03:37:11', 'Pending'),
(72, 11, 60000.00, 'bank_transfer', '2024-12-07 13:07:24', 'Pending'),
(73, 11, 160000.00, 'cash', '2024-12-07 23:49:22', 'Pending'),
(74, 11, 300000.00, 'bank_transfer', '2024-12-08 12:39:26', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 6, 0.00),
(2, 1, 3, 1, 0.00),
(3, 2, 2, 1, 0.00),
(4, 2, 3, 1, 0.00),
(5, 3, 2, 1, 0.00),
(6, 3, 3, 1, 0.00),
(7, 4, 2, 1, 0.00),
(8, 4, 3, 1, 0.00),
(9, 5, 2, 1, 0.00),
(10, 5, 3, 1, 0.00),
(11, 6, 2, 1, 0.00),
(12, 6, 3, 1, 0.00),
(13, 12, 2, 1, 0.00),
(14, 12, 3, 1, 0.00),
(15, 28, 2, 8, 0.00),
(16, 28, 3, 1, 0.00),
(17, 29, 1, 1, 0.00),
(18, 29, 2, 1, 0.00),
(19, 29, 3, 1, 0.00),
(20, 30, 3, 1, 0.00),
(21, 31, 2, 1, 0.00),
(22, 31, 3, 1, 0.00),
(23, 32, 2, 3, 0.00),
(24, 32, 3, 1, 0.00),
(25, 33, 2, 1, 0.00),
(26, 34, 2, 20, 0.00),
(27, 34, 1, 12, 0.00),
(28, 34, 6, 1, 0.00),
(29, 35, 2, 1, 0.00),
(30, 36, 2, 5, 0.00),
(31, 36, 5, 4, 0.00),
(32, 36, 7, 1, 0.00),
(33, 36, 6, 3, 0.00),
(34, 36, 4, 1, 0.00),
(35, 36, 1, 2, 0.00),
(36, 37, 2, 1, 0.00),
(37, 38, 3, 1, 0.00),
(38, 39, 2, 1, 0.00),
(39, 39, 3, 1, 0.00),
(40, 40, 2, 1, 0.00),
(41, 41, 1, 1, 0.00),
(42, 42, 2, 1, 0.00),
(43, 43, 2, 1, 0.00),
(44, 44, 1, 1, 0.00),
(45, 45, 2, 1, 0.00),
(46, 46, 2, 2, 0.00),
(47, 47, 2, 1, 0.00),
(48, 48, 2, 1, 0.00),
(49, 49, 2, 1, 0.00),
(50, 50, 7, 1, 0.00),
(51, 51, 2, 1, 0.00),
(52, 51, 3, 2, 0.00),
(53, 52, 1, 1, 0.00),
(54, 52, 5, 1, 0.00),
(55, 53, 2, 42, 0.00),
(56, 53, 5, 3, 0.00),
(57, 54, 2, 1, 0.00),
(58, 55, 5, 1, 0.00),
(59, 56, 2, 1, 0.00),
(60, 57, 2, 1, 0.00),
(61, 58, 2, 1, 0.00),
(62, 59, 2, 1, 0.00),
(63, 60, 2, 1, 0.00),
(64, 61, 2, 1, 0.00),
(65, 62, 2, 1, 0.00),
(66, 63, 2, 1, 0.00),
(67, 64, 2, 2, 0.00),
(68, 64, 3, 1, 0.00),
(69, 65, 2, 1, 0.00),
(70, 66, 2, 3, 0.00),
(71, 67, 2, 6, 0.00),
(72, 68, 2, 12, 0.00),
(73, 68, 5, 1, 0.00),
(74, 68, 1, 1, 0.00),
(75, 69, 2, 2, 0.00),
(76, 70, 3, 3, 0.00),
(77, 71, 5, 3, 0.00),
(78, 72, 2, 1, 0.00),
(79, 73, 2, 2, 0.00),
(80, 73, 6, 1, 0.00),
(81, 74, 5, 2, 0.00),
(82, 74, 1, 2, 0.00),
(83, 74, 2, 1, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remain_product` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image_url`, `created_at`, `remain_product`) VALUES
(1, 'Phở Bò', 50000.00, 'Phở bò nổi tiếng với nước dùng thanh ngọt và thịt bò mềm.', '../../assets/img/phobo.jpg', '2024-12-02 13:01:18', 2),
(2, 'Bún Chả', 60000.00, 'Bún chả Hà Nội với thịt nướng thơm lừng và nước chấm đặc trưng.', '../../assets/img/buncha.jpg', '2024-12-02 13:01:18', 2),
(3, 'Miến Gà', 45000.00, 'Miến gà thường được dùng trong bữa sáng và là món ăn không thể thiếu trong mâm cỗ ngày tết của nhiều gia đình miền Bắc. Nếu như tô miến gà miền Bắc, thịt gà thường được xé nhỏ, ăn kèm với mộc nhĩ, nấm hương, thì người miền Nam nấu miến gà với măng khô và gà được chặt miếng to. Nhưng dù chế biến như thế nào, miến gà vẫn là món ngon mỗi ngày giàu dinh dưỡng.', '../../assets/img/mienga.jpg', '2024-12-02 13:01:18', 1),
(4, 'Bánh Mì', 25000.00, 'Bánh mì là một loại baguette của Việt Nam với lớp vỏ ngoài giòn tan, ruột mềm, còn bên trong là phần nhân. Tùy theo văn hóa vùng miền hoặc sở thích cá nhân mà người ta có thể lựa chọn nhiều loại đồ ăn kèm khác nhau, ngoài ra tên gọi của bánh cũng phụ thuộc phần lớn vào những biến tấu ấy. Tuy nhiên, những phiên bản phổ biến nhất vẫn thường chứa chả lụa, thịt, cá hoặc thực phẩm chay, kèm theo một số nguyên liệu phụ khác như pa tê, bơ, rau, ớt, trứng và đồ chua. Bên cạnh đó, bánh còn có thể dùng chung với nhiều món ăn đa dạng, chẳng hạn như cá mòi, xíu mại hoặc thịt bò kho. Bánh mì được xem như một loại thức ăn nhanh bình dân phổ biến và thường được tiêu thụ vào bữa sáng hoặc bất kỳ bữa phụ nào trong ngày. Do có giá thành phù hợp nên bánh đã trở thành món ăn rất được nhiều người ưa chuộng.', '../../assets/img/banhmi.jpg', '2024-12-02 13:01:18', 1),
(5, 'Hủ Tiếu', 70000.00, 'Hủ tiếu Nam Vang là 1 trong những món hủ tiếu Sài Gòn được du nhập từ Campuchia. Tuy nhiên, khi về đến Sài Gòn, món ăn này được chế biến lại sao cho phù hợp với khẩu vị của người dân địa phương. Nồi nước dùng được nấu công phu, trong veo, mang vị thanh ngọt đặc trưng. ', '../../assets/img/hutieu.jpg', '2024-12-02 13:01:18', 1),
(6, 'Gỏi Cuốn', 40000.00, 'Gỏi cuốn, hay còn gọi là nem cuốn, là một món ăn nhẹ nhàng nhưng đầy hấp dẫn của ẩm thực Việt Nam. Những chiếc bánh tráng mỏng mềm bao bọc các nguyên liệu tươi ngon như tôm, thịt heo, bún tươi, cùng các loại rau sống giòn ngọt, mang lại cảm giác tươi mát, dễ chịu khi ăn. Món ăn này không chỉ có hương vị thơm ngon mà còn rất bổ dưỡng nhờ vào sự kết hợp hài hòa giữa các thành phần tự nhiên. Đặc biệt, gỏi cuốn thường được ăn kèm với nước chấm đậm đà, tạo nên một sự kết hợp hoàn hảo cho một bữa ăn nhẹ nhưng đầy đủ năng lượng.', '../../assets/img/goicuon.jpg', '2024-12-02 13:01:18', 1),
(7, 'Cơm Tấm', 60000.00, 'Cơm tấm – một món ăn đặc trưng của Sài Gòn, mang trong mình hương vị đặc biệt mà bất cứ ai cũng dễ dàng yêu thích ngay từ lần thử đầu tiên. Với cơm tấm mềm dẻo, sườn nướng thơm phức, và chả trứng béo ngậy, món ăn này tạo nên sự kết hợp hoàn hảo giữa các nguyên liệu tươi ngon và gia vị đậm đà. Đi kèm là bì, dưa leo và nước mắm chua ngọt, giúp cân bằng hương vị, mang lại một bữa ăn vừa đủ đầy, vừa thỏa mãn mọi khẩu vị. Cơm tấm không chỉ là món ăn mà còn là một phần không thể thiếu trong đời sống ẩm thực của người Sài Gòn, gắn liền với bao kỷ niệm và hương vị quen thuộc.', '../../assets/img/comtam.jpg', '2024-12-02 13:01:18', 1),
(34, 'Nước mía ', 20000.00, 'Nước mía là một loại nước phổ biến ở Việt Nam nhờ hương vị thơm ngon và thanh mát. ', '../../assets/img/67553927dac26.jpg', '2024-12-08 06:13:59', 1),
(35, 'TRÀ BÍ ĐAU', 20000.00, 'Thanh mát dịu nhẹ ', '../../assets/img/67553980e62d0.jpg', '2024-12-08 06:15:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `email`, `address`, `phone`, `dob`) VALUES
(1, 'john_doe', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(2, 'jane_smith', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(3, 'mike_jones', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(4, 'admin_user', 'adminpassword', 'admin', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(5, 'alice_williams', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(6, 'bob_brown', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(7, 'susan_miller', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(8, 'emily_davis', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(9, 'mark_clark', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(10, 'linda_lee', 'password123', 'customer', '2024-12-02 11:27:29', '', NULL, NULL, NULL),
(11, 'quy.nguyen050104', '$2y$10$.yiXw55Y1W9ol9E2c./Wo.ODuvwQNBlYUmur4QpXE31XB8P3Bi4CW', 'customer', '2024-12-02 11:45:13', 'quy.nguyen050104@hcmut.edu.vn', 'TÂN LẬP ĐÔNG HÒA DĨ AN BÌNH DƯƠNG ', '0855501412', '2004-01-06'),
(12, 'nguyendanganhtai', '$2y$10$g8FNN1Fkolnl6IY9bslnZuRrvgCXdtUK7kZc6YbBaWFokZVXOzFSG', 'customer', '2024-12-02 11:57:20', '', NULL, NULL, NULL),
(13, 'nguyenvana', 'password123', 'customer', '2024-12-02 16:49:32', 'nguyenvana@example.com', 'Hà Nội', '0123456789', '1990-01-01'),
(14, 'tranthib', 'password123', 'customer', '2024-12-02 16:49:32', 'tranthib@example.com', 'TP.HCM', '0987654321', '1992-02-02'),
(15, 'leminhc', 'password123', 'customer', '2024-12-02 16:49:32', 'leminhc@example.com', 'Đà Nẵng', '0912345678', '1985-03-03'),
(16, 'phamhoangd', 'password123', 'customer', '2024-12-02 16:49:32', 'phamhoangd@example.com', 'Hải Phòng', '0934567890', '1994-04-04'),
(17, 'vuquange', 'password123', 'customer', '2024-12-02 16:49:32', 'vuquange@example.com', 'Cần Thơ', '0976543210', '1987-05-05'),
(18, 'bui_thanhf', 'password123', 'customer', '2024-12-02 16:49:32', 'bui_thanhf@example.com', 'Quảng Ninh', '0901234567', '1991-06-06'),
(19, 'doanming', 'password123', 'customer', '2024-12-02 16:49:32', 'doanming@example.com', 'Hà Tĩnh', '0923456789', '1993-07-07'),
(20, 'ngothih', 'password123', 'customer', '2024-12-02 16:49:32', 'ngothih@example.com', 'Nghệ An', '0945678901', '1996-08-08'),
(21, 'hoangvani', 'password123', 'customer', '2024-12-02 16:49:32', 'hoangvani@example.com', 'Hải Dương', '0956789012', '1995-09-09'),
(22, 'lythik', 'password123', 'customer', '2024-12-02 16:49:32', 'lythik@example.com', 'Quảng Bình', '0967890123', '1997-10-10'),
(23, 'nguyenminhquy', '$2y$10$2479JJ580xipQyiG9gseD.7DuUIMm5DMLWJr55hKhlleA6oCALcwm', 'customer', '2024-12-02 16:54:46', 'quy.nguyen050104@hcmut.edu.vn', 'gregegergrg', '0855501412', '2024-12-19'),
(24, 'NGUYENTHITONGA', '$2y$10$BB/r4sK5Ioah0VbzlQ3ztOE1K7wNenFQ5eSQ3Nzb7xNajH9OoEEOe', 'customer', '2024-12-02 17:20:25', '', NULL, NULL, NULL),
(25, 'admin_minhquy', '$2y$10$XX8os1ZYwBnKFm4k6JTTFOY5rJTKq2mgym/pK6l7qFvSTLy/F7ynK', 'admin', '2024-12-02 17:33:12', '', NULL, NULL, NULL),
(26, 'admin_nguyenminhquy', '$2y$10$En0w4cehLMDpR5peaPy4TO5WNCVbqXQrPOShWurrmWKAdHOmHgwEW', 'admin', '2024-12-03 12:32:50', '', NULL, NULL, NULL),
(27, 'quoc', '$2y$10$GdgI1uxc2IG9s6e5Og7XFOMmaR6z7I/mh.n1vBRQrDVuj5aPrQp3S', 'customer', '2024-12-06 12:07:06', '', NULL, NULL, NULL),
(28, 'NGUYENTHINGANTHI', '$2y$10$8d5Zs5AY8fVXxDFJ2XUIFuLMCZTGxwFtnSzEa6S8xzFAD9F5rVjEy', 'customer', '2024-12-07 15:15:19', '', NULL, NULL, NULL),
(29, 'admin_an', '$2y$10$kMDTsa6YPc.yfti2xs0SKOqygW7rRu2mtJg1hauu9u.wyPdLuli4K', 'admin', '2024-12-07 23:50:27', '', NULL, NULL, NULL),
(30, 'nguyenthithu', '$2y$10$2NNoOsH1CQcpwNfPFs6tOu/Yk9S5aSQxnm1P/h.qL39Py0lzGgCd2', 'customer', '2024-12-08 12:40:56', '', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
