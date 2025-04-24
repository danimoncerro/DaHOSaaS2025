<div class="container mt-5 mb-5">
    <h3>Adaugă un produs nou</h3>
    <form action="process_add_product.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Nume produs -->
            <div class="col-md-6 mb-3">
                <label for="nume" class="form-label">Nume produs</label>
                <input type="text" class="form-control" id="nume" name="nume" required>
            </div>

            <!-- Pret -->
            <div class="col-md-3 mb-3">
                <label for="pret" class="form-label">Preț (lei)</label>
                <input type="number" step="0.01" class="form-control" id="pret" name="pret" required>
            </div>

            <!-- Stoc -->
            <div class="col-md-3 mb-3">
                <label for="stoc" class="form-label">Stoc</label>
                <input type="number" class="form-control" id="stoc" name="stoc" required>
            </div>

            <!-- Limita stoc scăzut -->
            <div class="col-md-4 mb-3">
                <label for="limita_stoc" class="form-label">Limită pentru stoc redus</label>
                <input type="number" class="form-control" id="limita_stoc" name="limita_stoc">
            </div>

            <!-- Unitate de măsură -->
            <div class="col-md-4 mb-3">
                <label for="unitate_masura" class="form-label">Unitate de măsură</label>
                <input type="text" class="form-control" id="unitate_masura" name="unitate_masura" placeholder="ex: buc, kg, l" required>
            </div>

            <!-- Imagine produs -->
            <div class="col-md-4 mb-3">
                <label for="imagine" class="form-label">Imagine produs</label>
                <input type="file" class="form-control" id="imagine" name="imagine" accept="image/*">
            </div>

            <!-- Descriere -->
            <div class="col-12 mb-3">
                <label for="descriere" class="form-label">Descriere</label>
                <textarea class="form-control" id="descriere" name="descriere" rows="4" placeholder="Descriere detaliată a produsului"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Salvează produsul</button>
    </form>
</div>
