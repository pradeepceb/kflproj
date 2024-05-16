@extends('Frontend.employee-report-header')
@extends('Frontend.employee-report-footer')
<body>

        <!--  BEGIN CONTENT AREA  -->
        <div  class="main-content">
                <div class="">
                    <div class="row layout-top-spacing">
                        <div id="tableCaption" class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                    	<div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                                    		<h5 class="data-heading1">The Samaj<span>Report run on: November 23, 2020 2:14 PM</span></h5>
                                            <h3 class="data-heading">EMPLOYEE MONTHLY  REMUNERATION REPORT</h3>
                                        </div>

                                         <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                  
                                                    <form method="get" action="/" class="form-inline report-area">
                                                    <label>Employee Type:</label>
                                                    <select class="col-lg-1 form-control">
                                                      <option>All </option>
                                                      <option>Permanent </option>
                                                      <option>Probation </option>
                                                    </select>
                                                      &nbsp;&nbsp;
                                                    <label>Category:</label>
									               <select class="col-lg-2 form-control">
									               	  <option>All Category</option>
									               	  <option>All Category</option>
									               	  <option>All Category</option>
									               </select>&nbsp;&nbsp;
                                                   <label>Salary Month & Year:</label>
                                                   <select name="month" class="col-lg-2 form-control">
                                                        <option value="01">January</option>
                                                        <option value="02">February</option>
                                                        <option value="03">March</option>
                                                        <option value="04">April</option>
                                                        <option value="05">May</option>
                                                        <option value="06">June</option>
                                                        <option value="07">July</option>
                                                        <option value="08">August</option>
                                                        <option value="09">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;

                                                    <select name="month" class="col-lg-1 form-control">
                                                        <option value="2030">2030</option>
                                                          <option value="2029">2029</option>
                                                          <option value="2028">2028</option>
                                                          <option value="2027">2027</option>
                                                          <option value="2026">2026</option>
                                                          <option value="2025">2025</option>
                                                          <option value="2024">2024</option>
                                                          <option value="2023">2023</option>
                                                          <option value="2022">2022</option>
                                                          <option value="2021">2021</option>
                                                          <option value="2020">2020</option>
                                                          <option value="2019">2019</option>
                                                          <option value="2018">2018</option>
                                                          <option value="2017">2017</option>
                                                          <option value="2016">2016</option>
                                                          <option value="2015">2015</option>
                                                          <option value="2014">2014</option>
                                                          <option value="2013">2013</option>
                                                          <option value="2012">2012</option>
                                                          <option value="2011">2011</option>
                                                          <option value="2010">2010</option>
                                                          <option value="2009">2009</option>
                                                          <option value="2008">2008</option>
                                                          <option value="2007">2007</option>
                                                          <option value="2006">2006</option>
                                                          <option value="2005">2005</option>
                                                          <option value="2004">2004</option>
                                                          <option value="2003">2003</option>
                                                          <option value="2002">2002</option>
                                                          <option value="2001">2001</option>
                                                          <option value="2000">2000</option>
                                                          <option value="1999">1999</option>
                                                          <option value="1998">1998</option>
                                                          <option value="1997">1997</option>
                                                          <option value="1996">1996</option>
                                                          <option value="1995">1995</option>
                                                          <option value="1994">1994</option>
                                                          <option value="1993">1993</option>
                                                          <option value="1992">1992</option>
                                                          <option value="1991">1991</option>
                                                          <option value="1990">1990</option>
                                                          <option value="1989">1989</option>
                                                          <option value="1988">1988</option>
                                                          <option value="1987">1987</option>
                                                          <option value="1986">1986</option>
                                                          <option value="1985">1985</option>
                                                          <option value="1984">1984</option>
                                                          <option value="1983">1983</option>
                                                          <option value="1982">1982</option>
                                                          <option value="1981">1981</option>
                                                          <option value="1980">1980</option>
                                                          <option value="1979">1979</option>
                                                          <option value="1978">1978</option>
                                                          <option value="1977">1977</option>
                                                          <option value="1976">1976</option>
                                                          <option value="1975">1975</option>
                                                          <option value="1974">1974</option>
                                                          <option value="1973">1973</option>
                                                          <option value="1972">1972</option>
                                                          <option value="1971">1971</option>
                                                          <option value="1970">1970</option>
                                                          <option value="1969">1969</option>
                                                          <option value="1968">1968</option>
                                                          <option value="1967">1967</option>
                                                          <option value="1966">1966</option>
                                                          <option value="1965">1965</option>
                                                          <option value="1964">1964</option>
                                                          <option value="1963">1963</option>
                                                          <option value="1962">1962</option>
                                                          <option value="1961">1961</option>
                                                          <option value="1960">1960</option>
                                                          <option value="1959">1959</option>
                                                          <option value="1958">1958</option>
                                                          <option value="1957">1957</option>
                                                          <option value="1956">1956</option>
                                                          <option value="1955">1955</option>
                                                          <option value="1954">1954</option>
                                                          <option value="1953">1953</option>
                                                          <option value="1952">1952</option>
                                                          <option value="1951">1951</option>
                                                          <option value="1950">1950</option>
                                                          <option value="1949">1949</option>
                                                          <option value="1948">1948</option>
                                                          <option value="1947">1947</option>
                                                          <option value="1946">1946</option>
                                                          <option value="1945">1945</option>
                                                          <option value="1944">1944</option>
                                                          <option value="1943">1943</option>
                                                          <option value="1942">1942</option>
                                                          <option value="1941">1941</option>
                                                          <option value="1940">1940</option>
                                                          <option value="1939">1939</option>
                                                          <option value="1938">1938</option>
                                                          <option value="1937">1937</option>
                                                          <option value="1936">1936</option>
                                                          <option value="1935">1935</option>
                                                          <option value="1934">1934</option>
                                                          <option value="1933">1933</option>
                                                          <option value="1932">1932</option>
                                                          <option value="1931">1931</option>
                                                          <option value="1930">1930</option>
                                                          <option value="1929">1929</option>
                                                          <option value="1928">1928</option>
                                                          <option value="1927">1927</option>
                                                          <option value="1926">1926</option>
                                                          <option value="1925">1925</option>
                                                          <option value="1924">1924</option>
                                                          <option value="1923">1923</option>
                                                          <option value="1922">1922</option>
                                                          <option value="1921">1921</option>
                                                          <option value="1920">1920</option>
                                                          <option value="1919">1919</option>
                                                          <option value="1918">1918</option>
                                                          <option value="1917">1917</option>
                                                          <option value="1916">1916</option>
                                                          <option value="1915">1915</option>
                                                          <option value="1914">1914</option>
                                                          <option value="1913">1913</option>
                                                          <option value="1912">1912</option>
                                                          <option value="1911">1911</option>
                                                          <option value="1910">1910</option>
                                                          <option value="1909">1909</option>
                                                          <option value="1908">1908</option>
                                                          <option value="1907">1907</option>
                                                          <option value="1906">1906</option>
                                                          <option value="1905">1905</option>
                                                          <option value="1904">1904</option>
                                                          <option value="1903">1903</option>
                                                          <option value="1902">1902</option>
                                                          <option value="1901">1901</option>
                                                          <option value="1900">1900</option>
                                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;
									                
									                <button type="submit" class="btn btn-primary report-btn" value="">Search</button>
									                </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area"  style="padding-bottom: 0px;">
                                	<!-- <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                                	<button class="btn btn-secondary" onclick="window.pdf()"><i class="fa fa-file"></i> Save</button> -->
                                    <div class="table-responsive" style="margin-top: 5px;">
                                       <table class="table mb-4">
                                          <thead>
                                                <tr>
                                                <th class="t-th" rowspan="2">Sl. No</th>
                                                <th class="t-th" rowspan="2" >Employee Name</th>
                                                <th class="t-th" rowspan="2" >Employee Code</th>
                                                <th class="t-th" rowspan="2">Designation</th>
                                                <th class="t-th" rowspan="2">Department</th>
                                                
                                               
                                                <th class="t-th" colspan="4" style="horizontal-align : middle;text-align:center;  ">For Month Of Oct 2020</th>
                                                

                                            </tr>

                                            <tr>
                                                <th class="t-th" scope="col">Basic Salary</th>
                                                <th class="t-th" scope="col">Allowances</th>
                                                <th class="t-th" scope="col">Gross Salary</th>
                                                <th class="t-th" scope="col">Net Salary</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">01</td>
                                                    <td class="text-primary">SUSANTA KUMAR MOHANTY</td>
                                                    <td>007</td>
                                                    <td>Executive Editor</td>
                                                    <td class="">Editorial</td>
                                                    <td>34655.00</td>
                                                    <td>45770.00</td>
                                                    <td>80425.00</td>
                                                    <td>49044.00</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-center">01</td>
                                                    <td class="text-primary">ALOK KUMAR PATI</td>
                                                    <td>009</td>
                                                    <td>Sub-Editor</td>
                                                    <td class="">Editorial</td>
                                                    <td>26006.00</td>
                                                    <td>26759.00</td>
                                                    <td>52765.00</td>
                                                    <td>37978.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                              
                                    </div>


                                </div>
                                 <div class="widget-header" style="padding: 20px;">
                                    <div class="row">
                                    	<div class="col-xl-6 col-md-12 col-sm-12 col-12 ">
                                    		<a href="#">Page 1 of 17</a>
                                        </div>
                                        <div class="col-xl-6 col-md-12 col-sm-12 col-12 ">
                                    		<div class="pagination">
											  <a href="#">&laquo;</a>
											  <a href="#">1</a>
											  <a href="#" class="active">2</a>
											  <a href="#">3</a>
											  <a href="#">4</a>
											  <a href="#">5</a>
											  <a href="#">6</a>
											  <a href="#">&raquo;</a>
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

        </div>
        <!--  END CONTENT AREA  -->
     