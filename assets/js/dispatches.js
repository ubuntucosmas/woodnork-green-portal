//<!-- JavaScript for Search and Receipt Generation -->
// Global variable to store dispatch data

let currentDispatches = [];

function initializeDispatchesForm() {
    const form = document.getElementById('dispatchesForm');
    const resultsContainer = document.getElementById('resultsContainer');
    const receiptContainer = document.getElementById('receiptContainer');

    if (!form || !resultsContainer || !receiptContainer) {
        console.log('Form, results container, or receipt container not found yet');
        return false;
    }

    console.log('Dispatches form initialized');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const dispatchId = form.querySelector('input[name="dispatch_id"]').value;

        if (!dispatchId) {
            resultsContainer.innerHTML = '<div class="alert alert-warning">Please enter a Dispatch ID</div>';
            return;
        }

        resultsContainer.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

        fetch(`pages/stores/store-actions/fetch_bulk_dispatch.php?dispatch_id=${encodeURIComponent(dispatchId)}`)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                console.log('Raw fetch response:', data);

                if (data.error) {
                    resultsContainer.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    return;
                }

                if (!data.specific_dispatches || !Array.isArray(data.specific_dispatches) || data.specific_dispatches.length === 0) {
                    resultsContainer.innerHTML = '<div class="alert alert-info">No records found</div>';
                    currentDispatches = [];
                    return;
                }

                currentDispatches = data.specific_dispatches;
                console.log('Current dispatches stored:', currentDispatches);

                let tableHTML = `
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Stock ID</th>
                                    <th>Project</th>
                                    <th>Destination</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Received By</th>
                                    <th>Issued By</th>
                                    <th>Status</th>
                                    <th>Dispatch ID</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                currentDispatches.forEach((dispatch, index) => {
                    console.log(`Table dispatch ${index}:`, dispatch);
                    tableHTML += `
                        <tr>
                            <td>${dispatch.id || 'N/A'}</td>
                            <td>${dispatch.stock_id || 'N/A'}</td>
                            <td>${dispatch.project || 'N/A'}</td>
                            <td>${dispatch.destination || 'N/A'}</td>
                            <td>${dispatch.quantity || 'N/A'}</td>
                            <td>${dispatch.dispatch_date || 'N/A'}</td>
                            <td>${dispatch.receiver || 'N/A'}</td>
                            <td>${dispatch.dispatcher || 'N/A'}</td>
                            <td>${dispatch.status || 'N/A'}</td>
                            <td>${dispatch.dispatch_id || 'N/A'}</td>
                        </tr>
                    `;
                });
                tableHTML += `
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <button class="btn btn-primary generate-receipt">
                                <i class="fas fa-print"></i> Print Receipt
                            </button>
                        </div>
                    </div>
                `;
                resultsContainer.innerHTML = tableHTML;

                document.querySelector('.generate-receipt').addEventListener('click', function() {
                    console.log('Generating receipt with:', currentDispatches);

                    if (!currentDispatches || currentDispatches.length === 0) {
                        receiptContainer.innerHTML = '<div class="alert alert-warning">No dispatch data available for receipt</div>';
                        receiptContainer.style.display = 'block';
                        console.error('No data to generate receipt');
                        return;
                    }

                    const dispatchId = currentDispatches[0].dispatch_id || 'Unknown';
                    let receiptHTML = `
                        <h3>Dispatch Receipt - Dispatch ID: ${dispatchId}</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Stock ID</th>
                                    <th>Project</th>
                                    <th>Destination</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Received By</th>
                                    <th>Issued By</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    currentDispatches.forEach((dispatch, index) => {
                        console.log(`Receipt dispatch ${index}:`, dispatch);
                        receiptHTML += `
                            <tr>
                                <td>${dispatch.id || 'N/A'}</td>
                                <td>${dispatch.stock_id || 'N/A'}</td>
                                <td>${dispatch.project || 'N/A'}</td>
                                <td>${dispatch.destination || 'N/A'}</td>
                                <td>${dispatch.quantity || 'N/A'}</td>
                                <td>${dispatch.dispatch_date || 'N/A'}</td>
                                <td>${dispatch.receiver || 'N/A'}</td>
                                <td>${dispatch.dispatcher || 'N/A'}</td>
                                <td>${dispatch.status || 'N/A'}</td>
                            </tr>
                        `;
                    });
                    receiptHTML += `
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <button class="btn btn-primary no-print" onclick="setTimeout(() => { console.log('Printing...'); window.print(); }, 1000)">Print Receipt</button>
                            <button class="btn btn-secondary no-print" onclick="document.getElementById('receiptContainer').style.display='none'">Clear</button>
                        </div>
                    `;
                    console.log('Receipt HTML generated:', receiptHTML);
                    receiptContainer.innerHTML = receiptHTML;
                    receiptContainer.style.display = 'block';

                    setTimeout(() => {
                        console.log('Receipt container content after render:', receiptContainer.innerHTML);
                        if (!receiptContainer.querySelector('tbody').children.length) {
                            console.error('Receipt table body is empty');
                        } else {
                            console.log('Receipt table body has', receiptContainer.querySelector('tbody').children.length, 'rows');
                        }
                    }, 200);
                });
            })
            .catch(error => {
                resultsContainer.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                console.error('Fetch error:', error);
                currentDispatches = [];
            });
    });
    return true;
}

if (!initializeDispatchesForm()) {
    const observer = new MutationObserver(function(mutations, observerInstance) {
        if (initializeDispatchesForm()) {
            observerInstance.disconnect();
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });
}