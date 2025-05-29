const BASE_URL = "https://nutrifitplanner.site";

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    // Configurar logout
    const logoutLink = document.getElementById("logout-link");
    if (logoutLink) {
        logoutLink.addEventListener("click", handleLogout);
    }


    // Configurar botones de periodo
    setupPeriodButtons();

    // Cargar datos del dashboard
    dashboard.loadData();
    
    // Configurar chat en mantenimiento
    setupChatMaintenance();

    // Auto-actualización cada 5 minutos
    setInterval(() => dashboard.loadData(), 30000);
});

// Utilidades optimizadas
const util = {
    getToken: () => localStorage.getItem("remember_token") || util.getCookie("remember_token"),
    
    getCookie: (name) => {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        return parts.length === 2 ? parts.pop().split(";").shift() : null;
    },

    checkAuth() {
        const token = this.getToken();
        if (!token) {
            this.showError("No hay sesión activa. Por favor inicie sesión nuevamente.", () => {
                window.location.href = "../../index.php";
            });
            return false;
        }
        return token;
    },

    showError: (message, callback) => {
        Swal.fire({
            title: "Error",
            text: message || "Ha ocurrido un error",
            icon: "error",
            confirmButtonText: "Aceptar",
        }).then(callback);
    },

    apiRequest: async (endpoint, options = {}) => {
        const token = util.getToken();
        const response = await fetch(`${BASE_URL}${endpoint}`, {
            headers: {
                "Content-Type": "application/json",
                "remember-token": token,
                ...options.headers
            },
            ...options
        });
        
        if (!response.ok) throw new Error(`Error ${response.status}: ${response.statusText}`);
        return response.json();
    },

    formatCurrency: (value) => {
        return new Intl.NumberFormat('es-MX', {
            style: 'currency',
            currency: 'MXN',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value);
    }
};

// Manejo de logout optimizado
const handleLogout = async (e) => {
    e.preventDefault();
    
    const token = util.getCookie("remember_token");
    if (!token) {
        window.location.href = '../../index.php';
        return;
    }

    try {
        await util.apiRequest("/api/logout", { method: "POST" });
    } catch (error) {
        console.warn("Error en logout:", error);
    } finally {
        document.cookie = "remember_token=; path=/; max-age=0";
        window.location.href = "../../index.php";
    }
};

// Configuración del dashboard
const dashboard = {
    selectors: [
        '.col-xl-3.col-md-6:nth-child(1)',
        '.col-xl-3.col-md-6:nth-child(2)', 
        '.col-xl-3.col-md-6:nth-child(3)',
        '.col-xl-3.col-md-6:nth-child(4)'
    ],
    
    dataKeys: ['pacientes', 'citas', 'planes_alimentacion', 'chats'],

    async loadData() {
        if (!util.checkAuth()) return;

        try {
            // Obtener el periodo activo (1M, 6M, 1Y, Todos)
            const periodoActivo = document.querySelector('.btn-soft-primary')?.textContent.trim() || '1Y';
            
            const data = await util.apiRequest(`/api/dashboard?periodo=${periodoActivo}`);
            console.log('Datos recibidos:', data); // Para debug
            
            this.updateUI(data);
            this.updateGrafica(data.grafica_resumen);
            this.updateResumenCards(data.grafica_resumen);
            this.updatePorcentajeEdadChart(data.porcentaje_por_edad);
            this.updatePorcentajeEnfermedadChart(data.porcentaje_por_enfermedad);
            this.updateConsultasRecientes(data.consultas_recientes);
        } catch (error) {
            console.error('Error cargando dashboard:', error);
            util.showError("Error al cargar datos del dashboard");
        }
    },

    updateUI(data) {
        // Actualizar saludo
        const welcomeEl = document.querySelector('.fs-16.mb-1');
        if (welcomeEl) {
            welcomeEl.textContent = `¡Hola! Bienvenido, ${data.nombre_nutriologo}`;
        }

        // Actualizar tarjetas
        this.dataKeys.forEach((key, index) => {
            this.updateCard(this.selectors[index], data[key]);
        });
        // Actualizar tabla de pacientes recientes
        if (data.pacientes_recientes) {
            this.updatePacientesRecientes(data.pacientes_recientes);
        }
        // Actualizar tabla de pacientes subsecuentes
        if (data.pacientes_subsecuentes) {
            this.updatePacientesSubsecuentes(data.pacientes_subsecuentes);
        }

        if (data.consultas_recientes) {
        this.updateConsultasRecientes(data.consultas_recientes);
    }
    },

    updateCard(selector, cardData) {
        const card = document.querySelector(selector);
        if (!card || !cardData) return;

        // Actualizar contador con animación
        const counter = card.querySelector('.counter-value');
        if (counter) {
            this.animateCounter(counter, cardData.total);
        }

        // Actualizar porcentaje y tendencia
        const percentageEl = card.querySelector('.fs-14.mb-0');
        if (percentageEl) {
            this.updateTrend(percentageEl, cardData);
        }
    },

    updateGrafica(graficaData) {
        if (!graficaData || !graficaData.meses || !graficaData.pacientes || !graficaData.ganancias || !graficaData.total_perdidas) {
            console.error('Datos de gráfica incompletos:', graficaData);
            return;
        }

        console.log('Datos de gráfica:', graficaData); // Para debug
        
        // Obtener colores del tema
        const linechartcustomerColors = getChartColorsArray("customer_impression_charts") || ["#28a745", "#17a2b8", "#dc3545"];
        
        // Configurar opciones de la gráfica
        const options = {
            series: [
                {
                    name: "Pacientes",
                    type: "column", // Cambié de "bar" a "column"
                    data: graficaData.pacientes.map(val => parseInt(val) || 0) // Asegurar que sean números
                },
                {
                    name: "Ganancias",
                    type: "area", 
                    data: graficaData.ganancias.map(val => parseFloat(val) || 0) // Asegurar que sean números
                },
                {
                    name: "Pérdidas",
                    type: "line",
                    data: graficaData.perdidas.map(val => parseFloat(val) || 0) // Asegurar que sean números
                }
            ],
            chart: { 
                height: 370, 
                type: "line", 
                toolbar: { show: false },
                zoom: { enabled: true }
            },
            stroke: { 
                curve: "smooth", 
                dashArray: [0, 0, 5], // [columna (sin dash), línea ganancias (sin dash), línea pérdidas (con dash)]
                width: [0, 5, 5] // [columna (sin stroke), líneas con grosor 3]
            },
            fill: { 
                opacity: [0.85, 0.25, 0.25],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            markers: { 
                size: [0, 6, 6], 
                strokeWidth: 2, 
                hover: { size: 8 },
                discrete: []
            },
            xaxis: {
                categories: graficaData.meses,
                axisTicks: { show: true },
                axisBorder: { show: true },
                labels: {
                    style: {
                        colors: '#8c9097',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: [
                {
                    title: {
                        text: 'Pacientes',
                        style: {
                            color: linechartcustomerColors[0],
                        }
                    },
                    labels: {
                        formatter: function (val) {
                            return Math.floor(val);
                        }
                    }
                },
                {
                    opposite: true,
                    title: {
                        text: 'Monto ($)',
                        style: {
                            color: linechartcustomerColors[1],
                        }
                    },
                    labels: {
                        formatter: function (val) {
                            return '$' + val.toFixed(0);
                        }
                    }
                }
            ],
            grid: {
                show: true,
                borderColor: '#f1f1f1',
                strokeDashArray: 0,
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: true } },
                padding: { top: 0, right: 0, bottom: 0, left: 0 },
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'center',
                floating: true,
                fontSize: '14px',
                offsetX: 0,
                offsetY: 0,
                markers: { 
                    width: 12, 
                    height: 12, 
                    strokeWidth: 0,
                    strokeColor: '#fff',
                    fillColors: undefined,
                    radius: 12,
                    customHTML: undefined,
                    onClick: undefined,
                    offsetX: 0,
                    offsetY: 0
                },
                itemMargin: { horizontal: 10, vertical: 5 },
            },
            plotOptions: { 
                bar: { 
                    horizontal: false,
                    columnWidth: "40%",
                    endingShape: "rounded"
                } 
            },
            colors: linechartcustomerColors,
            dataLabels: {
                enabled: false
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: [
                    {
                        formatter: function (val) {
                            return val ? Math.floor(val) + " pacientes" : "0 pacientes";
                        },
                    },
                    {
                        formatter: function (val) {
                            return val ? util.formatCurrency(val) : "$0.00";
                        },
                    },
                    {
                        formatter: function (val) {
                            return val ? util.formatCurrency(val) : "$0.00";
                        },
                    },
                ],
            },
        };

        // Destruir la gráfica existente si hay una
        if (window.resumenChart) {
            window.resumenChart.destroy();
        }

        // Crear nueva gráfica
        const chartElement = document.querySelector("#customer_impression_charts");
        if (chartElement) {
            window.resumenChart = new ApexCharts(chartElement, options);
            window.resumenChart.render();
        }
    },

    updatePacientesRecientes(pacientes) {
        const tbody = document.querySelector('.table-responsive table tbody');
        if (!tbody) return;

        // Limpiar tabla
        tbody.innerHTML = '';

        // Mostrar mensaje si no hay pacientes
        if (!pacientes || pacientes.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4">No hay pacientes recientes</td>
                </tr>
            `;
            return;
        }

        // Llenar tabla con pacientes
        pacientes.forEach(paciente => {
            const row = document.createElement('tr');
            
            // Foto o imagen por defecto
          const foto = paciente.foto 
            ? `<img src="${paciente.foto}" alt="${paciente.nombre_completo}" class="avatar-md p-2" />`
            : `<img src="../../assets/images/users/user-dummy-img.jpg" alt="Usuario" class="avatar-md p-2" />`;
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            ${foto}
                        </div>
                        <div>
                            <h5 class="fs-13 my-1">${paciente.nombre_completo}</h5>
                            <span class="text-muted">${paciente.fecha_creacion}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal">${paciente.telefono || 'N/A'}</h5>
                    <span class="text-muted">Teléfono</span>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal">${paciente.genero}</h5>
                    <span class="text-muted">Género</span>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal">${paciente.enfermedad || '<span class="badge bg-secondary">Ninguna</span>'}</h5>
                    <span class="text-muted">Enfermedad</span>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal">${paciente.edad}</h5>
                    <span class="text-muted">Edad</span>
                </td>
            `;
            
            tbody.appendChild(row);
        });
    } , 

    updatePacientesSubsecuentes(data) {
    const tbody = document.querySelector('#pacienteSubsecuente tbody');
    if (!tbody) {
        console.error('No se encontró el elemento tbody');
        return;
    }

    // Limpiar tabla
    tbody.innerHTML = '';

    // Mostrar mensaje si no hay pacientes
    if (!data.data || data.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">No hay pacientes subsecuentes</td>
            </tr>
        `;
        return;
    }

    // Llenar tabla con pacientes
    data.data.forEach(paciente => {
        const row = document.createElement('tr');
        
        // Foto o imagen por defecto
        const foto = paciente.foto 
            ? `<img src="${paciente.foto}" alt="${paciente.nombre_completo}" class="avatar-md p-2" />`
            : `<img src="../../assets/images/users/user-dummy-img.jpg" alt="Usuario" class="avatar-md p-2" />`;

        // Barra de progreso según el porcentaje
        const progressBar = `
            <div class="progress progress-sm">
                <div class="progress-bar bg-success" role="progressbar" style="width: ${paciente.porcentaje_asistencia}%" 
                    aria-valuenow="${paciente.porcentaje_asistencia}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        `;

        row.innerHTML = `
            <td>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        ${foto}
                    </div>
                    <div>
                        <h5 class="fs-13 my-1">${paciente.nombre_completo}</h5>
                        <span class="text-muted">${paciente.fecha_creacion}</span>
                    </div>
                </div>
            </td>
            <td>
                <span class="text-muted">${paciente.telefono || 'N/A'}</span>
            </td>
            <td>
                <p class="mb-0">${paciente.edad}</p>
                <span class="text-muted">Edad</span>
            </td>
            <td>
                <span class="text-muted">${util.formatCurrency(paciente.precio_cita)}</span>
            </td>
            <td>
                <h5 class="fs-13 fw-semibold mb-0">
                    ${paciente.porcentaje_asistencia}%
                    <i class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                </h5>
                ${progressBar}
                <small class="text-muted">${paciente.citas_seguimiento} citas de seguimiento</small>
            </td>
        `;
        
        tbody.appendChild(row);
    });

    // Actualizar paginación
    this.updatePagination(data);
}, updatePorcentajeEdadChart: function(data) {
    if (!data || !data.labels || !data.series) {
        console.error('Datos de porcentaje por edad incompletos:', data);
        return;
    }

    // Obtener colores del tema
    const colors = getChartColorsArray("store-visits-source");
    if (!colors) {
        console.error('No se pudieron obtener los colores del gráfico');
        return;
    }

    const options = {
        series: data.series,
        labels: data.labels,
        chart: {
            height: 333,
            type: 'donut',
        },
        legend: {
            position: 'bottom'
        },
        stroke: {
            show: false
        },
        dataLabels: {
            dropShadow: {
                enabled: false
            },
            formatter: function(val, opts) {
                return val.toFixed(1) + '%';
            }
        },
        colors: colors,
        tooltip: {
            y: {
                formatter: function(value, { seriesIndex, w }) {
                    return value.toFixed(1) + '% (' + 
                        Math.round((value / 100) * data.total) + ' pacientes)';
                }
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total pacientes',
                            formatter: function(w) {
                                return data.total;
                            }
                        }
                    }
                }
            }
        }
    };

    // Destruir gráfica existente si hay una
    if (window.porcentajeEdadChart) {
        window.porcentajeEdadChart.destroy();
    }

    // Crear nueva gráfica
    const chartElement = document.querySelector("#store-visits-source");
    if (chartElement) {
        window.porcentajeEdadChart = new ApexCharts(chartElement, options);
        window.porcentajeEdadChart.render();
    }
},updatePorcentajeEnfermedadChart: function(data) {
    if (!data || !data.labels || !data.series) {
        console.error('Datos de porcentaje por enfermedad incompletos:', data);
        return;
    }

    // Obtener colores del tema
    const colors = getChartColorsArray("simple_pie_chart");
    if (!colors) {
        console.error('No se pudieron obtener los colores del gráfico');
        return;
    }

    const options = {
        series: data.series,
        labels: data.labels,
        chart: {
            height: 300,
            type: 'pie',
        },
        legend: {
            position: 'bottom'
        },
        stroke: {
            show: false
        },
        dataLabels: {
            dropShadow: {
                enabled: false
            },
            formatter: function(val, opts) {
                return val.toFixed(1) + '%';
            }
        },
        colors: colors,
        tooltip: {
            y: {
                formatter: function(value, { seriesIndex, w }) {
                    return value.toFixed(1) + '% (' + 
                        Math.round((value / 100) * data.total) + ' pacientes)';
                }
            }
        }
    };

    // Destruir gráfica existente si hay una
    if (window.porcentajeEnfermedadChart) {
        window.porcentajeEnfermedadChart.destroy();
    }

    // Crear nueva gráfica
    const chartElement = document.querySelector("#simple_pie_chart");
    if (chartElement) {
        window.porcentajeEnfermedadChart = new ApexCharts(chartElement, options);
        window.porcentajeEnfermedadChart.render();
    }
},updateConsultasRecientes: function(consultas) {
    const tbody = document.querySelector('#consultaRecientes tbody');
    if (!tbody) return;

    // Limpiar tabla
    tbody.innerHTML = '';

    // Mostrar mensaje si no hay consultas
    if (!consultas || consultas.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">No hay consultas recientes</td>
            </tr>
        `;
        return;
    }

    // Llenar tabla con consultas
    consultas.forEach(consulta => {
        const row = document.createElement('tr');
        
        // Foto o imagen por defecto
        const foto = consulta.foto 
            ? `<img src="${consulta.foto}" alt="${consulta.nombre_paciente}" class="avatar-xs rounded-circle" />`
            : `<img src="../../assets/images/users/user-dummy-img.jpg" alt="Usuario" class="avatar-xs rounded-circle" />`;

        row.innerHTML = `
            <td>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        ${foto}
                    </div>
                    <div class="flex-grow-1">
                        ${consulta.nombre_paciente} ${consulta.apellidos}
                        <small class="text-muted d-block">${consulta.fecha_consulta}</small>
                    </div>
                </div>
            </td>
            <td>${consulta.nombre_consultorio}</td>
            <td>
                <span class="text-success">${util.formatCurrency(consulta.total_pago)}</span>
            </td>
            <td>${consulta.nombre_nutriologo}</td>
            <td>
                <span class="badge bg-success-subtle text-success">${consulta.tipo_consulta}</span>
            </td>
        `;
        
        tbody.appendChild(row);
    });
} ,

    updatePagination(data) {
        const paginationContainer = document.querySelector('.pagination-separated');
        if (!paginationContainer) return;

        // Limpiar paginación
        paginationContainer.innerHTML = '';

        // Botón Anterior
        const prevBtn = document.createElement('li');
        prevBtn.className = `page-item ${data.current_page === 1 ? 'disabled' : ''}`;
        prevBtn.innerHTML = `<a class="page-link" href="#">←</a>`;
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (data.current_page > 1) {
                this.loadSubsecuentesData(data.current_page - 1);
            }
        });
        paginationContainer.appendChild(prevBtn);

        // Páginas
        for (let i = 1; i <= data.last_page; i++) {
            const pageItem = document.createElement('li');
            pageItem.className = `page-item ${i === data.current_page ? 'active' : ''}`;
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageItem.addEventListener('click', (e) => {
                e.preventDefault();
                this.loadSubsecuentesData(i);
            });
            paginationContainer.appendChild(pageItem);
        }

        // Botón Siguiente
        const nextBtn = document.createElement('li');
        nextBtn.className = `page-item ${data.current_page === data.last_page ? 'disabled' : ''}`;
        nextBtn.innerHTML = `<a class="page-link" href="#">→</a>`;
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (data.current_page < data.last_page) {
                this.loadSubsecuentesData(data.current_page + 1);
            }
        });
        paginationContainer.appendChild(nextBtn);

        // Actualizar texto de resultados
        const resultsText = document.querySelector('.text-muted span.fw-semibold:first-child');
        const totalResults = document.querySelector('.text-muted span.fw-semibold:last-child');
        if (resultsText && totalResults) {
            resultsText.textContent = Math.min(data.per_page, data.data.length);
            totalResults.textContent = data.total;
        }
    },

    async loadSubsecuentesData(page = 1) {
        if (!util.checkAuth()) return;

        try {
            const data = await util.apiRequest(`/api/dashboard?page=${page}`);
            if (data.pacientes_subsecuentes) {
                this.updatePacientesSubsecuentes(data.pacientes_subsecuentes);
            }
        } catch (error) {
            console.error('Error cargando pacientes subsecuentes:', error);
        }
    },


    updateResumenCards(graficaData) {
    if (!graficaData) return;
    
    // Actualizar pacientes con animación
    const pacientesEl = document.querySelector('.col-4.col-lx-3:nth-child(1) .counter-value');
    if (pacientesEl && graficaData.total_pacientes !== undefined) {
        this.animateCounter(pacientesEl, graficaData.total_pacientes);
    }
    
    // Actualizar ganancias con animación y formato de moneda
    const gananciasEl = document.querySelector('.col-4.col-lx-3:nth-child(2) .counter-value');
    if (gananciasEl && graficaData.total_ganancias !== undefined) {
        this.animateCurrencyCounter(gananciasEl, graficaData.total_ganancias);
    }
    
    // Actualizar pérdidas con animación y formato de moneda
    const perdidasEl = document.querySelector('.col-4.col-lx-3:nth-child(3) .counter-value');
    if (perdidasEl && graficaData.total_perdidas !== undefined) {
        this.animateCurrencyCounter(perdidasEl, graficaData.total_perdidas);
    }

    
},




// Nueva función para animar valores monetarios
animateCurrencyCounter(element, targetValue) {
    const startValue = parseFloat(element.textContent.replace(/[^0-9.-]/g, '')) || 0;
    const target = parseFloat(targetValue) || 0;
    
    // Si el valor no cambió, no hacer animación
    if (startValue === target) {
        element.textContent = util.formatCurrency(target);
        return;
    }

    const duration = 1500; // 1.5 segundos
    const increment = (target - startValue) / (duration / 16); // 60 FPS
    let currentValue = startValue;
    
    element.setAttribute('data-target', target);
    
    const timer = setInterval(() => {
        currentValue += increment;
        
        // Si llegamos al objetivo o lo pasamos
        if ((increment > 0 && currentValue >= target) || 
            (increment < 0 && currentValue <= target)) {
            currentValue = target;
            clearInterval(timer);
        }
        
        // Formatear como moneda
        element.textContent = util.formatCurrency(currentValue);
    }, 16); // ~60 FPS
},

    animateCounter(element, targetValue) {
        const startValue = parseInt(element.textContent.replace(/,/g, '')) || 0;
        const target = parseInt(targetValue) || 0;
        
        // Si el valor no cambió, no hacer animación
        if (startValue === target) return;

        const duration = 1500; // 1.5 segundos
        const increment = (target - startValue) / (duration / 16); // 60 FPS
        let currentValue = startValue;
        
        element.setAttribute('data-target', target);
        
        const timer = setInterval(() => {
            currentValue += increment;
            
            // Si llegamos al objetivo o lo pasamos
            if ((increment > 0 && currentValue >= target) || 
                (increment < 0 && currentValue <= target)) {
                currentValue = target;
                clearInterval(timer);
            }
            
            // Formatear número con separadores de miles
            element.textContent = Math.round(currentValue).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }, 16); // ~60 FPS
    },

    updateTrend(element, { porcentaje, tendencia }) {
        if (!element) return;
        
        element.textContent = `${porcentaje >= 0 ? '+' : ''}${porcentaje}%`;
        
        // Limpiar clases previas
        element.classList.remove('text-success', 'text-danger', 'text-muted');
        
        // Aplicar nueva clase
        const trendClass = {
            'up': 'text-success',
            'down': 'text-danger',
            'neutral': 'text-muted'
        };
        element.classList.add(trendClass[tendencia] || 'text-muted');

        // Actualizar icono
        let arrowIcon = element.querySelector('i');
        if (!arrowIcon) {
            arrowIcon = document.createElement('i');
            element.prepend(arrowIcon);
        }
        
        const iconClass = {
            'up': 'ri-arrow-right-up-line fs-13 align-middle',
            'down': 'ri-arrow-right-down-line fs-13 align-middle',
            'neutral': 'ri-arrow-right-line fs-13 align-middle'
        };
        
        if (iconClass[tendencia]) {
            arrowIcon.className = iconClass[tendencia];
        } else {
            arrowIcon.className = 'ri-arrow-right-line fs-13 align-middle';
        }
    }
};

// Configurar chat link (funcionalidad en mantenimiento)
const setupChatMaintenance = () => {
    const chatLink = document.getElementById('chat-link');
    if (chatLink) {
        chatLink.addEventListener('click', (e) => {
            e.preventDefault();
            Swal.fire({
                title: 'Sección en mantenimiento',
                text: 'La sección de chats está actualmente en mantenimiento.',
                icon: 'info',
                confirmButtonText: 'Entendido'
            });
        });
    }
};

const setupChatMenuMaintenance2 = () => {
    const chatMenuLinks = document.querySelectorAll('a[data-key="t-chat"]');
    if (chatMenuLinks) {
        chatMenuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: 'Sección en mantenimiento',
                    text: 'La sección de chats está actualmente en mantenimiento.',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
            });
        });
    }
};

// Función para manejar los botones de periodo
const setupPeriodButtons = () => {
    const buttons = document.querySelectorAll('.card-header button');
    if (!buttons.length) return;
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Quitar clase active de todos los botones
            buttons.forEach(btn => {
                btn.classList.remove('btn-soft-primary');
                btn.classList.add('btn-soft-dark');
            });
            
            // Añadir clase active al botón clickeado
            this.classList.remove('btn-soft-dark');
            this.classList.add('btn-soft-primary');
            
            // Recargar datos con el nuevo periodo
            dashboard.loadData();
        });
    });
};

// Configurar dropdown de reportes
const setupReportDropdown = () => {
    const dropdownItems = document.querySelectorAll('.dropdown-menu-end a.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.textContent.trim();
            
            if (action === 'Download Report') {
                // Implementar lógica de descarga
                Swal.fire({
                    title: 'Descargar reporte',
                    text: '¿Desea descargar el reporte de pacientes subsecuentes?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Descargar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `${BASE_URL}/api/export/subsecuentes?token=${util.getToken()}`;
                    }
                });
            }
        });
    });
};
