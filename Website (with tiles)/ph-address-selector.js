/**
 * __________________________________________________________________
 *
 * Phillipine Address Selector
 * __________________________________________________________________
 *
 * MIT License
 * 
 * Copyright (c) 2020 Wilfred V. Pine
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package Phillipine Address Selector
 * @author Wilfred V. Pine <only.master.red@gmail.com>
 * @copyright Copyright 2020 (https://dev.confired.com)
 * @link https://github.com/redmalmon/philippine-address-selector
 * @license https://opensource.org/licenses/MIT MIT License
 */

var my_handlers = {
    // fill city
    fill_cities: function () {
        //selected province
        var province_code = $(this).val();

        // set selected text to input
        var province_text = $(this).find("option:selected").text();
        console.log("Selected province:", province_text);
        let province_input = $('#province-text');
        province_input.val(province_text);
        //clear city & barangay input
        $('#city-text').val('');
        $('#barangay-text').val('');

        //city
        let dropdown = $('#city');
        dropdown.empty();
        // dropdown.append('<option selected="true" disabled>Choose city/municipality</option>');
        dropdown.prop('selectedIndex', 0);

        //barangay
        let barangay = $('#barangay');
        barangay.empty();
        barangay.append('<option selected="true" disabled></option>');
        barangay.prop('selectedIndex', 0);

        // Filter & fill
        var url = 'ph-json/city.json';
        $.getJSON(url, function (data) {
            var result = data.filter(function (value) {
                return value.province_code == province_code;
            });

            result.sort(function (a, b) {
                return a.city_name.localeCompare(b.city_name);
            });

            console.log("Cities for selected province:", result);

            $.each(result, function (key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.city_code).text(entry.city_name));
            })

        });
    },
    // fill barangay
    fill_barangays: function () {
       
        // Selected city code
        var city_code = $(this).val();
    
        // Clear barangay input
        $('#barangay-text').val('');
    
        // Barangay dropdown
        let dropdown = $('#barangay');
        dropdown.empty();
        //dropdown.append('<option selected="true" disabled>Choose barangay</option>');
        dropdown.prop('selectedIndex', 0);
    
        // Filter and fill barangays based on the selected city code
        var url = 'ph-json/barangay.json';
        $.getJSON(url, function (data) {
            console.log("Barangay data:", data);
    
            var result = data.filter(function (value) {
                console.log("Checking barangay:", value.city_code, city_code);
                return value.city_code === city_code; // Filter based on selected city code
            });
    
            result.sort(function (a, b) {
                return a.brgy_name.localeCompare(b.brgy_name);
            });
    
            console.log("Barangays for selected city:", result);
    
            // Populate the barangay dropdown
            $.each(result, function (key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.brgy_code).text(entry.brgy_name));
            });
        });
    },
    

    onchange_barangay: function () {
        // set selected text to input
        var barangay_text = $(this).find("option:selected").text();
        let barangay_input = $('#barangay-text');
        barangay_input.val(barangay_text);
    },
};




$(function () {
    // Load NCR cities on page load
    loadNCRCities();

    // Function to load NCR cities
    function loadNCRCities() {
        // Load NCR region code
        const ncrRegionCode = '13'; // NCR region code
        console.log("Loading NCR cities...");

        // Load cities based on NCR region code
        loadCitiesByRegion(ncrRegionCode);
    }

    // Function to load cities based on region code
    function loadCitiesByRegion(regionCode) {
        console.log("Loading cities for region code: " + regionCode);

        // Load cities based on the provided region code
        var url = 'ph-json/city.json';
        $.getJSON(url, function (data) {
            var ncrCities = data.filter(function (value) {
                return value.region_desc === regionCode; // Adjusted to use region_desc
            });
            console.log("NCR cities loaded:", ncrCities);

            // Populate the city dropdown with NCR cities
            populateDropdown(ncrCities, $('#city'));
        });
    }


    // Function to populate dropdown with options
    function populateDropdown(options, dropdown) {
        console.log("Populating dropdown with options:", options);

        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Choose city/municipality</option>');
        dropdown.prop('selectedIndex', 0);

        // Append options to the dropdown
        $.each(options, function (key, entry) {
            dropdown.append($('<option></option>').attr('value', entry.city_code).text(entry.city_name));
        });
    }

    // Bind the fill_barangays function to the change event of the city dropdown
    $('#city').on('change', my_handlers.fill_barangays);
});
