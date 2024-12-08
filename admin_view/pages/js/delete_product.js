
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');
    let maxHeight = 0;

    // Tìm chiều cao lớn nhất trong các thẻ sản phẩm
    productCards.forEach(card => {
        const cardHeight = card.offsetHeight;
        if (cardHeight > maxHeight) {
            maxHeight = cardHeight;
        }
    });

    // Áp dụng chiều cao lớn nhất cho tất cả các thẻ sản phẩm
    productCards.forEach(card => {
        card.style.height = maxHeight + 'px';
    });
});

