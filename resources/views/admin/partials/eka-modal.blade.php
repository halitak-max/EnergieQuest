<!-- EKA Modal -->
<div id="ekaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-8 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white flex flex-col max-h-[calc(100vh-4rem)]">
        <div class="flex-shrink-0">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Energiekostenanalyse</h3>
                <button onclick="closeEkaModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Ihr aktueller Anbieter -->
                <div class="border rounded-lg p-4">
                    <h4 class="font-bold text-sm mb-3">Ihr aktueller Anbieter</h4>
                    <div class="space-y-2 text-sm">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Anbieter Name</label>
                            <input type="text" id="current-provider" class="w-full border rounded px-2 py-1 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Tarif</label>
                            <input type="text" id="current-tariff" class="w-full border rounded px-2 py-1 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">PLZ/Ort</label>
                            <input type="text" id="current-location" class="w-full border rounded px-2 py-1 text-xs" onchange="copyToNewProvider('location')">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</label>
                            <input type="number" id="current-consumption" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateCurrentCosts(); copyToNewProvider('consumption');">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Anzahl Monate</label>
                            <input type="number" id="current-months" class="w-full border rounded px-2 py-1 text-xs" value="12" onchange="calculateCurrentCosts(); copyToNewProvider('months');">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</label>
                            <input type="number" step="0.01" id="current-working-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateCurrentCosts()">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</label>
                            <input type="number" step="0.01" id="current-basic-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateCurrentCosts()">
                        </div>
                        <div class="pt-2 border-t">
                            <div class="text-xs">
                                <div class="flex justify-between mb-1">
                                    <span>Gesamtkosten EUR (Verbrauch):</span>
                                    <span id="current-consumption-cost">0.00</span>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span>Grundpreis/Jahr EUR:</span>
                                    <span id="current-basic-year">0.00</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span>Gesamtkosten EUR:</span>
                                    <span id="current-total">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ihr neuer Anbieter -->
                <div class="border rounded-lg p-4">
                    <h4 class="font-bold text-sm mb-3">Ihr neuer Anbieter</h4>
                    <div class="space-y-2 text-sm">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Anbieter Name</label>
                            <input type="text" id="new-provider" class="w-full border rounded px-2 py-1 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Tarif</label>
                            <input type="text" id="new-tariff" class="w-full border rounded px-2 py-1 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">PLZ/Ort</label>
                            <input type="text" id="new-location" class="w-full border rounded px-2 py-1 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</label>
                            <input type="number" id="new-consumption" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateNewCosts()">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Anzahl Monate</label>
                            <input type="number" id="new-months" class="w-full border rounded px-2 py-1 text-xs" value="12" onchange="calculateNewCosts()">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</label>
                            <input type="number" step="0.01" id="new-working-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateNewCosts()">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</label>
                            <input type="number" step="0.01" id="new-basic-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateNewCosts()">
                        </div>
                        <div class="pt-2 border-t">
                            <div class="text-xs">
                                <div class="flex justify-between mb-1">
                                    <span>Gesamtkosten EUR (Verbrauch):</span>
                                    <span id="new-consumption-cost">0.00</span>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span>Grundpreis/Jahr EUR:</span>
                                    <span id="new-basic-year">0.00</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span>Gesamtkosten EUR:</span>
                                    <span id="new-total">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ersparnis -->
                <div class="border rounded-lg p-4">
                    <h4 class="font-bold text-sm mb-3">Ersparnis</h4>
                    <div class="space-y-2 text-sm">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Ersparnis Jahr 1 (EUR)</label>
                            <input type="number" step="0.01" id="savings-year1-eur" class="w-full border rounded px-2 py-1 text-xs" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Ersparnis Jahr 1 (%)</label>
                            <input type="number" step="0.1" id="savings-year1-percent" class="w-full border rounded px-2 py-1 text-xs" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Ersparnis Jahr 2 (EUR)</label>
                            <input type="number" step="0.01" id="savings-year2-eur" class="w-full border rounded px-2 py-1 text-xs" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Ersparnis Jahr 2 (%)</label>
                            <input type="number" step="0.1" id="savings-year2-percent" class="w-full border rounded px-2 py-1 text-xs" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Maximale Ersparnis (EUR)</label>
                            <input type="number" step="0.01" id="savings-max-eur" class="w-full border rounded px-2 py-1 text-xs" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Maximale Ersparnis (%)</label>
                            <input type="number" step="0.1" id="savings-max-percent" class="w-full border rounded px-2 py-1 text-xs" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex-shrink-0 mt-4 flex justify-end gap-3">
            <button onclick="closeEkaModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Abbrechen</button>
            <button onclick="saveEkaData()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Speichern</button>
        </div>
    </div>
</div>

