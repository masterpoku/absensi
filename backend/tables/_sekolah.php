        <div class="row my-4">
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Sekolah dan Pemilik</h6>
                            </div>
                            <div class="col-lg-6 col-5 text-end">
                                <input type="text" id="search" class="form-control form-control-sm" placeholder="Cari sekolah atau pemilik..." oninput="fetchSchools(1)">
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Sekolah</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Pemilik</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody id="schoolsTable">
                                    <!-- Dynamic content goes here -->
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination justify-content-center mt-3" id="pagination">
                                <!-- Pagination links will be dynamically generated -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                <h6>Lisensi Akan Expired</h6>
                </div>
                <div class="card-body p-3">
                    <div id="schoolsList">
                        <!-- Data sekolah akan dimuat di sini -->
                    </div>

                    <nav>
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                </div>
            </div>
            </div>
        </div>
      
        <script>
            // Fetch schools data
            function fetchSchools(page = 1) {
                const limit = 10; // Batasi jumlah data per halaman
                const offset = (page - 1) * limit;
                const search = document.getElementById('search').value.trim(); // Ambil nilai input pencarian

                // Fetch data dari endpoint PHP
                fetch(`data/fetch_schools_with_users.php?limit=${limit}&offset=${offset}&search=${encodeURIComponent(search)}`)
                    .then(response => response.json())
                    .then(data => {
                        const schoolsTable = document.getElementById('schoolsTable');
                        const pagination = document.getElementById('pagination');

                        // Clear existing table rows
                        schoolsTable.innerHTML = '';

                        // Populate table rows
                        if (data.length > 0) {
                            data.forEach(school => {
                                schoolsTable.innerHTML += `
                                    <tr>
                                        <td>${school.nama_sekolah}</td>
                                        <td>${school.alamat}</td>
                                        <td>${school.status === 1 ? 'Aktif' : 'Tidak Aktif'}</td>
                                        <td>${school.user_nama || 'Tidak Diketahui'}</td>
                                        <td>${school.username || '-'}</td>
                                        <td>${school.email || '-'}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            schoolsTable.innerHTML = `
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                                </tr>
                            `;
                        }

                        // Generate pagination
                        generatePagination(page, limit, data.length === limit);
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Generate pagination dynamically
            function generatePagination(currentPage, limit, hasNextPage) {
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';

                // Previous button
                if (currentPage > 1) {
                    pagination.innerHTML += `
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="fetchSchools(${currentPage - 1})">Previous</a>
                        </li>
                    `;
                }

                // Current page
                pagination.innerHTML += `
                    <li class="page-item active">
                        <span class="page-link">${currentPage}</span>
                    </li>
                `;

                // Next button
                if (hasNextPage) {
                    pagination.innerHTML += `
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="fetchSchools(${currentPage + 1})">Next</a>
                        </li>
                    `;
                }
            }

            // Event listener for search input
            document.getElementById('search').addEventListener('input', () => {
                fetchSchools(1); // Fetch data dari halaman pertama setiap kali input pencarian berubah
            });

            // Initial fetch
            fetchSchools();

            // Fetch data sekolah dengan lisensi yang akan expired
            function fetchSchoolsWithExpiringLicenses(page = 1) {
                const limit = 10; // Batasi jumlah data per halaman
                const offset = (page - 1) * limit;

                // Fetch data dari endpoint PHP
                fetch(`data/fetch_schools_with_expiring_licenses.php?limit=${limit}&offset=${offset}`)
                    .then(response => response.json())
                    .then(data => {
                        const schoolsList = document.getElementById('schoolsList');
                        const pagination = document.getElementById('pagination');

                        // Clear existing list
                        schoolsList.innerHTML = '';

                        // Populate schools list
                        if (data.length > 0) {
                            data.forEach(school => {
                                schoolsList.innerHTML += `
                                
                                    
                                            
                                                <div class="timeline timeline-one-side">
                                                    <div class="timeline-block mb-3">
                                                        <span class="timeline-step">
                                                            <i class="fas fa-dot-circle text-danger text-gradient"></i>
                                                        </span>
                                                        <div class="timeline-content">
                                                        <h6>${school.nama_sekolah}</h6>
                                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Lisensi akan expired dalam ${school.days_until_expiration} hari</h6>
                                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Expired pada: ${school.valid_until}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                    
                                    
                                `;
                            });
                        } else {
                            schoolsList.innerHTML = `
                                <div class="col-12">
                                    <div class="alert alert-warning text-center">
                                        Tidak ada data ditemukan
                                    </div>
                                </div>
                            `;
                        }

                        // Generate pagination
                        generatePagination(page, limit, data.length === limit);
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Generate pagination dynamically
            function generatePagination(currentPage, limit, hasNextPage) {
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';

                // Previous button
                if (currentPage > 1) {
                    pagination.innerHTML += `
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="fetchSchoolsWithExpiringLicenses(${currentPage - 1})">Previous</a>
                        </li>
                    `;
                }

                // Current page
                pagination.innerHTML += `
                    <li class="page-item active">
                        <span class="page-link">${currentPage}</span>
                    </li>
                `;

                // Next button
                if (hasNextPage) {
                    pagination.innerHTML += `
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="fetchSchoolsWithExpiringLicenses(${currentPage + 1})">Next</a>
                        </li>
                    `;
                }
            }

            // Initial fetch
            fetchSchoolsWithExpiringLicenses();
        </script>