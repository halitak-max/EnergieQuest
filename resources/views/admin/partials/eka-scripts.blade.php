<script>
    function openEkaModal(referralId) {
        loadEkaData('referral', referralId);
        document.getElementById('ekaModal').classList.remove('hidden');
        document.getElementById('ekaModal').dataset.referralId = referralId;
        document.getElementById('ekaModal').dataset.type = 'referral';
    }

    function openUserEkaModal(userId) {
        loadEkaData('user', userId);
        document.getElementById('ekaModal').classList.remove('hidden');
        document.getElementById('ekaModal').dataset.userId = userId;
        document.getElementById('ekaModal').dataset.type = 'user';
    }

    function loadEkaData(type, id) {
        const url = type === 'user' 
            ? `/admin/users/${id}/eka`
            : `/admin/referrals/${id}/eka`;
        
        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('current-provider').value = data.current_provider || '';
            document.getElementById('current-tariff').value = data.current_tariff || '';
            document.getElementById('current-location').value = data.current_location || '';
            document.getElementById('current-consumption').value = data.current_consumption || '';
            document.getElementById('current-months').value = data.current_months || 12;
            document.getElementById('current-working-price').value = data.current_working_price || '';
            document.getElementById('current-basic-price').value = data.current_basic_price || '';
            
            document.getElementById('new-provider').value = data.new_provider || '';
            document.getElementById('new-tariff').value = data.new_tariff || '';
            document.getElementById('new-location').value = data.new_location || '';
            document.getElementById('new-consumption').value = data.new_consumption || '';
            document.getElementById('new-months').value = data.new_months || 12;
            document.getElementById('new-working-price').value = data.new_working_price || '';
            document.getElementById('new-basic-price').value = data.new_basic_price || '';
            
            document.getElementById('savings-year1-eur').value = data.savings_year1_eur || '';
            document.getElementById('savings-year1-percent').value = data.savings_year1_percent || '';
            document.getElementById('savings-year2-eur').value = data.savings_year2_eur || '';
            document.getElementById('savings-year2-percent').value = data.savings_year2_percent || '';
            document.getElementById('savings-max-eur').value = data.savings_max_eur || '';
            document.getElementById('savings-max-percent').value = data.savings_max_percent || '';
            
            calculateCurrentCosts();
            calculateNewCosts();
            calculateSavings();
        })
        .catch(error => {
            console.error('Error loading EKA data:', error);
        });
    }

    function closeEkaModal() {
        document.getElementById('ekaModal').classList.add('hidden');
        delete document.getElementById('ekaModal').dataset.referralId;
        delete document.getElementById('ekaModal').dataset.userId;
        delete document.getElementById('ekaModal').dataset.type;
    }

    function copyToNewProvider(field) {
        const currentValue = document.getElementById(`current-${field}`).value;
        document.getElementById(`new-${field}`).value = currentValue;
        if (field === 'consumption' || field === 'months') {
            calculateNewCosts();
        }
    }

    function calculateCurrentCosts() {
        const consumption = parseFloat(document.getElementById('current-consumption').value) || 0;
        const workingPrice = parseFloat(document.getElementById('current-working-price').value) || 0;
        const basicPrice = parseFloat(document.getElementById('current-basic-price').value) || 0;
        const months = parseFloat(document.getElementById('current-months').value) || 12;
        
        const consumptionCost = (consumption * workingPrice) / 100;
        const basicYear = basicPrice * months;
        const total = consumptionCost + basicYear;
        
        document.getElementById('current-consumption-cost').textContent = consumptionCost.toFixed(2);
        document.getElementById('current-basic-year').textContent = basicYear.toFixed(2);
        document.getElementById('current-total').textContent = total.toFixed(2);
        
        calculateSavings();
    }

    function calculateNewCosts() {
        const consumption = parseFloat(document.getElementById('new-consumption').value) || 0;
        const workingPrice = parseFloat(document.getElementById('new-working-price').value) || 0;
        const basicPrice = parseFloat(document.getElementById('new-basic-price').value) || 0;
        const months = parseFloat(document.getElementById('new-months').value) || 12;
        
        const consumptionCost = (consumption * workingPrice) / 100;
        const basicYear = basicPrice * months;
        const total = consumptionCost + basicYear;
        
        document.getElementById('new-consumption-cost').textContent = consumptionCost.toFixed(2);
        document.getElementById('new-basic-year').textContent = basicYear.toFixed(2);
        document.getElementById('new-total').textContent = total.toFixed(2);
        
        calculateSavings();
    }

    function calculateSavings() {
        const currentTotal = parseFloat(document.getElementById('current-total').textContent) || 0;
        const newTotal = parseFloat(document.getElementById('new-total').textContent) || 0;
        
        if (currentTotal > 0) {
            const savingsYear1 = currentTotal - newTotal;
            const savingsPercent = ((currentTotal - newTotal) / currentTotal) * 100;
            const savingsYear2 = savingsYear1;
            const savingsMax = savingsYear1 * 2;

            document.getElementById('savings-year1-eur').value = savingsYear1.toFixed(2);
            document.getElementById('savings-year1-percent').value = savingsPercent.toFixed(1);
            document.getElementById('savings-year2-eur').value = savingsYear2.toFixed(2);
            document.getElementById('savings-year2-percent').value = savingsPercent.toFixed(1);
            document.getElementById('savings-max-eur').value = savingsMax.toFixed(2);
            document.getElementById('savings-max-percent').value = savingsPercent.toFixed(1);
        }
    }

    function saveEkaData() {
        const modal = document.getElementById('ekaModal');
        const type = modal.dataset.type;
        const referralId = modal.dataset.referralId;
        const userId = modal.dataset.userId;
        
        calculateCurrentCosts();
        calculateNewCosts();
        calculateSavings();
        
        const currentTotalText = document.getElementById('current-total').textContent.trim();
        const newTotalText = document.getElementById('new-total').textContent.trim();
        const currentTotal = parseFloat(currentTotalText.replace(/[^\d.,]/g, '').replace(',', '.')) || 0;
        const newTotal = parseFloat(newTotalText.replace(/[^\d.,]/g, '').replace(',', '.')) || 0;
        
        const data = {
            current_provider: document.getElementById('current-provider').value,
            current_tariff: document.getElementById('current-tariff').value,
            current_location: document.getElementById('current-location').value,
            current_consumption: document.getElementById('current-consumption').value,
            current_months: document.getElementById('current-months').value,
            current_working_price: document.getElementById('current-working-price').value,
            current_basic_price: document.getElementById('current-basic-price').value,
            current_total: currentTotal,
            new_provider: document.getElementById('new-provider').value,
            new_tariff: document.getElementById('new-tariff').value,
            new_location: document.getElementById('new-location').value,
            new_consumption: document.getElementById('new-consumption').value,
            new_months: document.getElementById('new-months').value,
            new_working_price: document.getElementById('new-working-price').value,
            new_basic_price: document.getElementById('new-basic-price').value,
            new_total: newTotal,
            savings_year1_eur: parseFloat(document.getElementById('savings-year1-eur').value) || 0,
            savings_year1_percent: parseFloat(document.getElementById('savings-year1-percent').value) || 0,
            savings_year2_eur: parseFloat(document.getElementById('savings-year2-eur').value) || 0,
            savings_year2_percent: parseFloat(document.getElementById('savings-year2-percent').value) || 0,
            savings_max_eur: parseFloat(document.getElementById('savings-max-eur').value) || 0,
            savings_max_percent: parseFloat(document.getElementById('savings-max-percent').value) || 0,
        };
        
        const url = type === 'user'
            ? `/admin/users/${userId}/eka`
            : `/admin/referrals/${referralId}/eka`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('EKA-Daten erfolgreich gespeichert!');
                closeEkaModal();
                location.reload();
            } else {
                alert('Fehler beim Speichern: ' + (data.message || 'Unbekannter Fehler'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Fehler beim Speichern der EKA-Daten');
        });
    }

    document.getElementById('ekaModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEkaModal();
        }
    });
</script>

