<?php include_once 'app/views/share/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function addcart(id) {
        $.ajax({
            url: "/chieu2/cart/add/"+id,
            success: function (response) {
                alert("thêm sản phẩm thành công");
            }
        });
    }
</script>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <a href="/chieu2/product/add" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Thêm Sản Phẩm</span>
            </a>
            <a href="/chieu2/cart/show" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Giỏ Hàng</span>
            </a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-12">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Mô Tả</th>
                        <th>Hình Ảnh</th>
                        <th>Giá</th>
                        <th>Hành Động (Sửa/Xóa)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                        <td> <button class="btn btn-danger" onclick="addcart(<?php echo $row['id']; ?>)">ADD TO CART</button></td>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td>
                                <?php if (empty($row['image']) || !file_exists($row['image'])): ?>
                                    No Image!
                                <?php else: ?>
                                    <img src="/chieu2/<?= $row['image'] ?>" alt="Hình ảnh" class="img-fluid" />
                                <?php endif; ?>
                            </td>
                            <td><?= $row['price'] ?></td>
                            <td>
                                <a href="/chieu2/product/edit/<?= $row['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="/chieu2/product/delete/<?= $row['id'] ?>" class="btn btn-sm btn-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once 'app/views/share/footer.php'; ?>