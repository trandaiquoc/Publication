<div class="split-container">
    <div class="image-half">
        <img src="./public/images/error.png" alt="Error Image">
    </div>
    <div class="text-half">
        <p>Có chút lỗi rồi ><</p>
    </div>
</div>
<style>
    .split-container {
    display: flex;
    flex-direction: row;
    }

    .image-half {
        width: 50%; /* Chiếm 1 nửa màn hình */
    }

    .image-half img {
        max-width: 100%; /* Đảm bảo hình ảnh không vượt quá kích thước của phần tử */
        height: auto;
        display: block;
        margin: 0 auto; /* Căn giữa hình ảnh */
    }

    .text-half {
        width: 50%; /* Chiếm 1 nửa màn hình */
        font-size: 50px; /* Font chữ lớn */
        color: red;
        display: flex;
        align-items: center; /* Căn giữa nội dung văn bản theo chiều dọc */
        justify-content: center; /* Căn giữa nội dung văn bản theo chiều ngang */
    }
</style>