@extends('layouts.frontend')

@section('title', 'Solar Inquiry - AJ Electric')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-orange-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                🌞 AJ Electric Solar Inquiry
            </h1>
            <p class="text-lg text-gray-600">
                Serving Islamabad, Rawalpindi & Surrounding Regions
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            
            <!-- Section 1: Customer Details -->
            <div class="mb-8">
                <h2 class="bg-blue-600 text-white py-3 px-4 rounded-lg text-lg font-semibold mb-6">
                    1. Customer Details
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="name" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Enter your name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">City Selection</label>
                        <select id="city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Islamabad">Islamabad</option>
                            <option value="Rawalpindi">Rawalpindi</option>
                            <option value="Wahcantt">Wahcantt</option>
                            <option value="Abbottabad">Abbottabad</option>
                            <option value="Haripur">Haripur</option>
                            <option value="Fatehjang">Fatehjang</option>
                            <option value="Other">Other Surrounding Areas</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: System Preference -->
            <div class="mb-8">
                <h2 class="bg-blue-600 text-white py-3 px-4 rounded-lg text-lg font-semibold mb-6">
                    2. System Preference
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Installation Type</label>
                        <select id="systemType" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="On-Grid Solar System">On-Grid Solar System</option>
                            <option value="Hybrid Solar System">Hybrid Solar System</option>
                            <option value="Off-Grid Solar System">Off-Grid Solar System</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Required Capacity</label>
                        <select id="capacity" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="5kW">5kW</option>
                            <option value="10kW">10kW</option>
                            <option value="15kW">15kW</option>
                            <option value="20kW">20kW</option>
                            <option value="Above 20kW">Up to 40kW</option>
                        </select>
                    </div>
                </div>

                <!-- Bill Upload -->
                <div class="mt-6 bg-yellow-50 border-2 border-dashed border-yellow-300 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📸 Upload Bill Photo (Optional on Web - Please attach in WhatsApp)
                    </label>
                    <input type="file" id="billFile" accept="image/*,.pdf" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <p class="text-xs text-gray-600 mt-2">
                        <i>Tip: Attach a clear photo of your bill in WhatsApp for a faster quote.</i>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Average Monthly Bill (PKR)</label>
                        <input type="number" id="billAmount" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="e.g. 45000">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Estimated Budget (PKR)</label>
                        <input type="text" id="budget" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="e.g. 1.5 Million">
                    </div>
                </div>
            </div>

            <!-- Section 3: Appliance Details -->
            <div class="mb-8">
                <h2 class="bg-blue-600 text-white py-3 px-4 rounded-lg text-lg font-semibold mb-6">
                    3. Appliance Quantity (Load Details)
                </h2>
                <div class="bg-gray-50 p-6 rounded-lg border">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Appliance Items -->
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">AC (1.5 Ton Inverter)</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="AC 1.5T" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Water Pump (Motor)</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Water Pump" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">AC (1 Ton Inverter)</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="AC 1T" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Iron / Steamer</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Iron" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Refrigerator (Fridge)</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Fridge" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Washing Machine</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Washing Machine" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Deep Freezer</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Deep Freezer" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Electric Kettle</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Kettle" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Ceiling Fans</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Fans" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Microwave Oven</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Microwave" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">LED Lights</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="Lights" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">LED TV</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="TV" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Computers/Laptops</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="PC/Laptop" value="0" min="0">
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <label class="font-medium text-gray-700">Security Cameras</label>
                            <input type="number" class="qty w-16 px-2 py-1 border border-gray-300 rounded text-center" 
                                   data-name="CCTV" value="0" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Additional Information -->
            <div class="mb-8">
                <h2 class="bg-blue-600 text-white py-3 px-4 rounded-lg text-lg font-semibold mb-6">
                    4. Additional Information
                </h2>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Remarks / Special Instructions
                    </label>
                    <textarea id="remarks" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                              placeholder="Mention any specific requirements here..."></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="button" onclick="sendWhatsApp()" 
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg class="w-6 h-6 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.570-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.595z"/>
                    </svg>
                    Send Details to WhatsApp
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function sendWhatsApp() {
    const phoneNumber = "{{ preg_replace('/[^\d]/', '', $siteSettings->solar_contact_whatsapp ?? '923315346889') }}"; 
    
    const name = document.getElementById('name').value;
    const city = document.getElementById('city').value;
    const system = document.getElementById('systemType').value;
    const capacity = document.getElementById('capacity').value;
    const bill = document.getElementById('billAmount').value;
    const budget = document.getElementById('budget').value;
    const remarks = document.getElementById('remarks').value;

    let loadDetails = "";
    const qtys = document.querySelectorAll('.qty');
    qtys.forEach(item => {
        if(item.value > 0) {
            loadDetails += `%0A- ${item.getAttribute('data-name')}: ${item.value}`;
        }
    });

    const message = `*AJ ELECTRIC SOLAR INQUIRY*%0A` +
                    `---------------------------%0A` +
                    `*Customer:* ${name}%0A` +
                    `*City:* ${city}%0A%0A` +
                    `*SYSTEM CONFIG*%0A` +
                    `*Type:* ${system}%0A` +
                    `*Capacity:* ${capacity}%0A` +
                    `*Monthly Bill:* ${bill} PKR%0A` +
                    `*Budget:* ${budget}%0A%0A` +
                    `*LOAD DETAILS:* ${loadDetails}%0A%0A` +
                    `*REMARKS:* ${remarks}%0A%0A` +
                    `_Please attach your bill photo below this message!_`;

    const waURL = `https://wa.me/${phoneNumber}?text=${message}`;
    window.open(waURL, '_blank');
}
</script>
@endsection
