<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Super Manager</title>
    <!-- Подключаем Chart.js для графиков -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Иконки -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f3f4f6;
            --card-bg: #ffffff;
            --text: #1f2937;
            --text-light: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --border: #e5e7eb;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--card-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.02);
            z-index: 10;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn {
            background: none;
            border: none;
            width: 100%;
            padding: 12px 15px;
            text-align: left;
            cursor: pointer;
            border-radius: 8px;
            color: var(--text-light);
            font-size: 1rem;
            margin-bottom: 5px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn:hover {
            background-color: #f9fafb;
            color: var(--primary);
        }

        .nav-btn.active {
            background-color: var(--primary);
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-outline {
            background-color: white;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            background-color: #f9fafb;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* Cards & Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }

        .card h3 {
            margin-top: 0;
            color: var(--text-light);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--text);
            margin: 10px 0;
        }

        .stat-trend {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .trend-up { color: var(--success); }
        .trend-down { color: var(--danger); }

        /* Tables & Lists */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid var(--border);
        }

        th {
            color: var(--text-light);
            font-weight: 600;
            font-size: 0.85rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .priority-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .p-high { background: #fee2e2; color: #991b1b; }
        .p-medium { background: #fef3c7; color: #92400e; }
        .p-low { background: #d1fae5; color: #065f46; }

        .status-checkbox {
            transform: scale(1.2);
            cursor: pointer;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /* Sections visibility */
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }

        /* Knowledge Base Tags */
        .kb-tag {
            display: inline-block;
            padding: 2px 8px;
            background: #e0e7ff;
            color: var(--primary);
            border-radius: 4px;
            font-size: 0.8rem;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .ai-tip {
            background: #ecfdf5;
            border-left: 4px solid var(--success);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .ai-tip h4 { margin: 0 0 5px 0; color: #065f46; }
        .ai-tip p { margin: 0; color: #047857; font-size: 0.9rem; }

        /* Gamefication */
        .level-badge {
            background: linear-gradient(45deg, #ffd700, #ffa500);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.8rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Focus Mode Overlay */
        #focus-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #1f2937;
            color: white;
            z-index: 2000;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        #focus-timer {
            font-size: 8rem;
            font-weight: bold;
            font-variant-numeric: tabular-nums;
            margin: 20px 0;
        }
        #focus-task-name {
            font-size: 2rem;
            color: #9ca3af;
            margin-bottom: 20px;
        }
        .focus-controls button {
            font-size: 1.2rem;
            padding: 15px 30px;
            margin: 0 10px;
        }

        /* GSC Specific Styles */
        .gsc-metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .gsc-card-mini {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid var(--border);
        }
        .gsc-val { font-size: 1.5rem; font-weight: bold; color: var(--primary); }
        .gsc-label { font-size: 0.8rem; color: var(--text-light); }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-rocket"></i> SEO Master
        </div>
        <button class="nav-btn active" onclick="showSection('dashboard')">
            <i class="fas fa-chart-line"></i> Дашборд
        </button>
        <button class="nav-btn" onclick="showSection('projects')">
            <i class="fas fa-folder"></i> Проекты
        </button>
        <button class="nav-btn" onclick="showSection('tasks')">
            <i class="fas fa-check-circle"></i> Задачи
        </button>
        <button class="nav-btn" onclick="showSection('gsc')">
            <i class="fab fa-google"></i> GSC Аналитика
        </button>
        <button class="nav-btn" onclick="showSection('knowledge')">
            <i class="fas fa-brain"></i> База Знаний
        </button>
        <button class="nav-btn" onclick="showSection('settings')">
            <i class="fas fa-cog"></i> Настройки
        </button>

        <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid var(--border);">
            <div style="font-size: 0.8rem; color: var(--text-light); margin-bottom: 5px;">Ваш уровень</div>
            <div id="user-level" class="level-badge">Новичок</div>
            <div style="font-size: 0.7rem; color: var(--text-light); margin-top: 5px;" id="xp-progress">XP: 0 / 100</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Dashboard Section -->
        <div id="dashboard" class="section active">
            <div class="header">
                <h1>Обзор эффективности</h1>
                <div class="actions">
                    <button class="btn btn-outline" onclick="exportData()"><i class="fas fa-download"></i> Бэкап</button>
                    <button class="btn btn-outline" onclick="document.getElementById('importFile').click()"><i class="fas fa-upload"></i> Восстановить</button>
                    <input type="file" id="importFile" style="display: none" onchange="importData(this)">
                </div>
            </div>

            <div class="ai-tip" id="ai-suggestion">
                <h4><i class="fas fa-lightbulb"></i> Совет дня</h4>
                <p>Загрузка анализа...</p>
            </div>

            <div class="grid">
                <div class="card">
                    <h3>Активные проекты</h3>
                    <div class="stat-value" id="dash-active-projects">0</div>
                </div>
                <div class="card">
                    <h3>Ожидаемая прибыль (мес)</h3>
                    <div class="stat-value" id="dash-revenue">$0</div>
                    <div class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> Сумма контрактов</div>
                </div>
                <div class="card">
                    <h3>Расходы (мес)</h3>
                    <div class="stat-value" id="dash-expenses">$0</div>
                    <div class="stat-trend trend-down"><i class="fas fa-arrow-up"></i> Сервисы + Работа</div>
                </div>
                <div class="card">
                    <h3>Чистая ставка (час)</h3>
                    <div class="stat-value" id="dash-rate">$0</div>
                    <div class="stat-trend" id="dash-rate-trend">Норма</div>
                </div>
            </div>

            <div class="grid">
                <div class="card" style="grid-column: span 2;">
                    <h3>Финансы: Доход vs Расход</h3>
                    <div class="chart-container">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Статус задач</h3>
                    <div class="chart-container">
                        <canvas id="tasksChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="grid">
                <div class="card" style="grid-column: span 1;">
                    <h3>Воронка времени (Распределение)</h3>
                    <div class="chart-container">
                        <canvas id="timeFunnelChart"></canvas>
                    </div>
                </div>
                <div class="card" style="grid-column: span 2;">
                    <h3><i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i> Зоны риска (Стоп-факторы)</h3>
                    <div id="risk-factors" style="margin-top: 10px;">
                        <p style="color: var(--text-light);">Анализ проектов...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        <div id="projects" class="section">
            <div class="header">
                <h1>Мои Проекты</h1>
                <button class="btn btn-primary" onclick="openProjectModal()"><i class="fas fa-plus"></i> Новый проект</button>
            </div>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Приоритет</th>
                            <th>Доход ($)</th>
                            <th>Расход ($)</th>
                            <th>Время (ч/мес)</th>
                            <th>ROI</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="projects-table-body">
                        <!-- JS will populate -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tasks Section -->
        <div id="tasks" class="section">
            <div class="header">
                <h1>Задачи</h1>
                <button class="btn btn-primary" onclick="openTaskModal()"><i class="fas fa-plus"></i> Добавить задачу</button>
            </div>

            <div style="margin-bottom: 20px; display: flex; gap: 10px;">
                <select id="task-filter-project" class="form-group" style="padding: 10px; border-radius: 6px; border: 1px solid var(--border);" onchange="renderTasks()">
                    <option value="all">Все проекты</option>
                </select>
                <select id="task-filter-status" class="form-group" style="padding: 10px; border-radius: 6px; border: 1px solid var(--border);" onchange="renderTasks()">
                    <option value="all">Все статусы</option>
                    <option value="pending">В ожидании</option>
                    <option value="done">Готово</option>
                </select>
            </div>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Статус</th>
                            <th>Задача</th>
                            <th>Проект</th>
                            <th>Категория</th>
                            <th>Время (ч)</th>
                            <th>Фокус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="tasks-table-body">
                        <!-- JS will populate -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- GSC Section -->
        <div id="gsc" class="section">
            <div class="header">
                <h1>Google Search Console</h1>
            </div>
            
            <div class="card" id="gsc-setup-card">
                <h3>Настройка подключения</h3>
                <p style="color: var(--text-light); margin-bottom: 15px;">
                    Для работы требуется Client ID из Google Cloud Console. 
                    Убедитесь, что в настройках OAuth добавлен адрес этого сайта (<span id="current-url" style="font-family: monospace; background: #eee; padding: 2px 5px; border-radius: 4px;"></span>) в разделы <b>Authorized JavaScript origins</b> и <b>Authorized redirect URIs</b>.
                </p>
                <div class="form-group">
                    <label>Client ID</label>
                    <input type="text" id="gsc-client-id" placeholder="Введите Client ID (например, 123...apps.googleusercontent.com)">
                </div>
                <button class="btn btn-primary" onclick="saveGscSettings()"><i class="fas fa-save"></i> Сохранить настройки</button>
                <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0;">
                <button class="btn btn-outline" onclick="connectGsc()" id="btn-connect-gsc" disabled><i class="fab fa-google"></i> Подключить Google Аккаунт</button>
                <p id="gsc-status" style="margin-top: 10px; font-size: 0.9rem;"></p>
            </div>

            <div id="gsc-dashboard" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 id="gsc-site-name">Сайт</h2>
                    <button class="btn btn-outline" onclick="disconnectGsc()">Отключить</button>
                </div>

                <div class="gsc-metrics-grid">
                    <div class="gsc-card-mini">
                        <div class="gsc-val" id="gsc-clicks">0</div>
                        <div class="gsc-label">Клики (90 дн)</div>
                    </div>
                    <div class="gsc-card-mini">
                        <div class="gsc-val" id="gsc-impressions">0</div>
                        <div class="gsc-label">Показы (90 дн)</div>
                    </div>
                    <div class="gsc-card-mini">
                        <div class="gsc-val" id="gsc-ctr">0%</div>
                        <div class="gsc-label">CTR</div>
                    </div>
                    <div class="gsc-card-mini">
                        <div class="gsc-val" id="gsc-position">0</div>
                        <div class="gsc-label">Ср. позиция</div>
                    </div>
                </div>

                <div class="grid">
                    <div class="card" style="grid-column: span 2;">
                        <h3>Динамика трафика</h3>
                        <div class="chart-container">
                            <canvas id="gscTrafficChart"></canvas>
                        </div>
                    </div>
                    <div class="card">
                        <h3>Умные подсказки</h3>
                        <div id="gsc-insights" style="font-size: 0.9rem;">
                            <!-- Insights injected here -->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3>Топ запросы (Quick Wins)</h3>
                    <table id="gsc-queries-table">
                        <thead>
                            <tr>
                                <th>Запрос</th>
                                <th>Позиция</th>
                                <th>CTR</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Knowledge Base Section -->
        <div id="knowledge" class="section">
            <div class="header">
                <h1>База Знаний SEO</h1>
            </div>

            <div class="grid">
                <div class="card">
                    <h3><i class="fas fa-bolt" style="color: gold;"></i> Быстрые победы</h3>
                    <p style="font-size: 0.9rem; color: var(--text-light);">Задачи, которые дают быстрый результат.</p>
                    <div id="kb-quick-wins"></div>
                </div>
                <div class="card">
                    <h3><i class="fas fa-shield-alt" style="color: var(--danger);"></i> Анти-паттерны</h3>
                    <p style="font-size: 0.9rem; color: var(--text-light);">Чего делать НЕ стоит.</p>
                    <div id="kb-antipatterns"></div>
                </div>
                <div class="card">
                    <h3><i class="fas fa-search" style="color: var(--primary);"></i> Стандартный аудит</h3>
                    <p style="font-size: 0.9rem; color: var(--text-light);">Базовый чеклист для старта.</p>
                    <div id="kb-audit"></div>
                </div>
                <div class="card">
                    <h3><i class="fas fa-magic" style="color: purple;"></i> Нестандартные ходы</h3>
                    <p style="font-size: 0.9rem; color: var(--text-light);">Для роста, когда всё сделано.</p>
                    <div id="kb-advanced"></div>
                </div>
            </div>
        </div>

        <!-- Settings Section -->
        <div id="settings" class="section">
            <div class="header">
                <h1>Настройки</h1>
            </div>
            <div class="card">
                <h3>Управление данными</h3>
                <p>Все данные хранятся локально в вашем браузере (LocalStorage). При очистке кэша браузера данные могут пропасть, поэтому регулярно делайте бэкап.</p>
                <button class="btn btn-danger" style="background: var(--danger); color: white;" onclick="clearAllData()">Полностью сбросить все данные</button>
            </div>
        </div>

    </div>

    <!-- Modals -->
    <!-- Project Modal -->
    <div id="projectModal" class="modal">
        <div class="modal-content">
            <h2 id="projectModalTitle">Новый проект</h2>
            <form id="projectForm">
                <input type="hidden" id="proj-id">
                <div class="form-group">
                    <label>Название проекта / Домен</label>
                    <input type="text" id="proj-name" required>
                </div>
                <div class="form-group">
                    <label>Приоритет</label>
                    <select id="proj-priority">
                        <option value="high">Высокий (A)</option>
                        <option value="medium" selected>Средний (B)</option>
                        <option value="low">Низкий (C)</option>
                    </select>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label>Доход в месяц ($)</label>
                        <input type="number" id="proj-revenue" value="0">
                    </div>
                    <div class="form-group">
                        <label>Расходы в месяц ($)</label>
                        <input type="number" id="proj-expenses" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label>План часов в месяц</label>
                    <input type="number" id="proj-hours" value="10">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('projectModal')">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Task Modal -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <h2 id="taskModalTitle">Новая задача</h2>
            <form id="taskForm">
                <input type="hidden" id="task-id">
                <div class="form-group">
                    <label>Описание задачи</label>
                    <input type="text" id="task-desc" required>
                </div>
                <div class="form-group">
                    <label>Проект</label>
                    <select id="task-project" required></select>
                </div>
                <div class="form-group">
                    <label>Категория</label>
                    <select id="task-category">
                        <option value="technical">Техническое SEO</option>
                        <option value="content">Контент</option>
                        <option value="links">Ссылки</option>
                        <option value="analytics">Аналитика</option>
                        <option value="other">Другое</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Затраченное время (часы)</label>
                    <input type="number" step="0.5" id="task-time" value="1">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('taskModal')">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Focus Mode Overlay -->
    <div id="focus-overlay">
        <div id="focus-task-name">Название задачи</div>
        <div id="focus-timer">25:00</div>
        <div class="focus-controls">
            <button class="btn btn-primary" onclick="toggleFocusTimer()" id="focus-toggle-btn">Старт</button>
            <button class="btn btn-outline" style="color: white; border-color: white;" onclick="exitFocusMode()">Выход</button>
        </div>
        <div style="margin-top: 30px; font-size: 0.9rem; color: #9ca3af;">Режим фокуса (Pomodoro)</div>
    </div>

   <script>
        // --- DATA STORE ---
        let db = {
            projects: [],
            tasks: [],
            xp: 0,
            gsc: {
                clientId: '',
                token: null,
                siteUrl: null
            }
        };

        const KB_DATA = {
            quickWins: [
                { title: "Сжать изображения (WebP)", time: 0.5 },
                { title: "Настроить 301 редиректы с www на без www", time: 0.2 },
                { title: "Обновить Title на главных посадочных", time: 0.5 },
                { title: "Добавить микроразметку Organization", time: 0.3 }
            ],
            antiPatterns: [
                { title: "Покупка ссылок на биржах-помойках" },
                { title: "Копипаст описаний товаров" },
                { title: "Скрытый текст (цвет в цвет)" },
                { title: "Переспам ключами в Title (>5 раз)" }
            ],
            audit: [
                { title: "Проверить robots.txt и sitemap.xml", time: 0.5 },
                { title: "Анализ скорости загрузки (Core Web Vitals)", time: 1.0 },
                { title: "Поиск битых ссылок (404)", time: 0.5 },
                { title: "Проверка дублей страниц", time: 1.0 }
            ],
            advanced: [
                { title: "Парсинг сниппетов конкурентов через API", time: 2.0 },
                { title: "Внедрение FAQ Schema на основе вопросов 'People Also Ask'", time: 1.5 },
                { title: "Анализ логов сервера для краулингового бюджета", time: 3.0 }
            ]
        };

        // --- INIT ---
        window.onload = function() {
            loadDataFromDB(); // Загрузка из БД вместо LocalStorage
            renderKnowledgeBase();
            
            document.getElementById('current-url').innerText = window.location.href.split('#')[0];
        };

        // --- CORE FUNCTIONS (DB VERSION) ---

        function loadDataFromDB() {
            fetch('api.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'action=get_data'
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    db.projects = data.projects;
                    db.tasks = data.tasks;
                    
                    // Восстанавливаем настройки
                    if(data.settings.user_xp) db.xp = parseInt(data.settings.user_xp);
                    if(data.settings.gsc_client_id) db.gsc.clientId = data.settings.gsc_client_id;
                    if(data.settings.gsc_token) db.gsc.token = data.settings.gsc_token;
                    if(data.settings.gsc_site_url) db.gsc.siteUrl = data.settings.gsc_site_url;

                    renderDashboard();
                    renderProjects();
                    renderTasks();
                    updateLevel();
                    generateAiTip();
                    initGsc();
                }
            })
            .catch(err => console.error('Ошибка загрузки:', err));
        }

        function saveDataToDB(callback) {
            // Эта функция теперь не нужна в старом виде, так как сохранение идет через конкретные действия в API
            // Но можно использовать для принудительной синхронизации если нужно
            if(callback) callback();
        }

        function clearAllData() {
            if(confirm("Вы уверены? Это удалит ВСЕ проекты и задачи из базы данных.")) {
                // Для простоты можно сделать отдельный экшн в API или просто очистить таблицы вручную
                alert("Для полного сброса очистите таблицы в phpMyAdmin или напишите отдельный скрипт.");
            }
        }

        // --- PROJECTS LOGIC ---

        function openProjectModal(id = null) {
            const modal = document.getElementById('projectModal');
            const form = document.getElementById('projectForm');
            form.reset();

            if (id) {
                const proj = db.projects.find(p => p.id == id); // Сравнение нестрогое, т.к. из БД строки могут прийти
                document.getElementById('proj-id').value = proj.id;
                document.getElementById('proj-name').value = proj.name;
                document.getElementById('proj-priority').value = proj.priority;
                document.getElementById('proj-revenue').value = proj.revenue;
                document.getElementById('proj-expenses').value = proj.expenses;
                document.getElementById('proj-hours').value = proj.hours;
                document.getElementById('projectModalTitle').innerText = "Редактировать проект";
            } else {
                document.getElementById('proj-id').value = '';
                document.getElementById('projectModalTitle').innerText = "Новый проект";
            }
            modal.style.display = 'flex';
        }

        document.getElementById('projectForm').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('proj-id').value;
            const formData = new FormData();
            formData.append('action', 'save_project');
            if(id) formData.append('id', id);
            formData.append('name', document.getElementById('proj-name').value);
            formData.append('priority', document.getElementById('proj-priority').value);
            formData.append('revenue', document.getElementById('proj-revenue').value);
            formData.append('expenses', document.getElementById('proj-expenses').value);
            formData.append('hours', document.getElementById('proj-hours').value);

            fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if(res.success) {
                    loadDataFromDB(); // Перезагружаем данные
                    closeModal('projectModal');
                } else {
                    alert('Ошибка сохранения');
                }
            });
        };

        function renderProjects() {
            const tbody = document.getElementById('projects-table-body');
            const filterSelect = document.getElementById('task-project');

            tbody.innerHTML = '';
            filterSelect.innerHTML = '<option value="all">Все проекты</option>';

            db.projects.forEach(p => {
                // Fill filter
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.innerText = p.name;
                filterSelect.appendChild(opt);

                // Calc ROI
                const profit = parseFloat(p.revenue) - parseFloat(p.expenses);
                const expVal = parseFloat(p.expenses);
                const roi = expVal > 0 ? ((profit / expVal) * 100).toFixed(0) : 0;

                let pClass = p.priority === 'high' ? 'p-high' : (p.priority === 'medium' ? 'p-medium' : 'p-low');
                let pText = p.priority === 'high' ? 'Высокий' : (p.priority === 'medium' ? 'Средний' : 'Низкий');

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><b>${p.name}</b></td>
                    <td><span class="priority-badge ${pClass}">${pText}</span></td>
                    <td>$${p.revenue}</td>
                    <td>$${p.expenses}</td>
                    <td>${p.hours} ч</td>
                    <td style="color: ${roi >= 0 ? 'var(--success)' : 'var(--danger)'}">${roi}%</td>
                    <td>
                        <button class="btn btn-outline" style="padding: 5px 10px;" onclick="openProjectModal(${p.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-outline" style="padding: 5px 10px; color: var(--danger);" onclick="deleteProject(${p.id})"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function deleteProject(id) {
            if(confirm('Удалить проект и все его задачи?')) {
                const formData = new FormData();
                formData.append('action', 'delete_project');
                formData.append('id', id);

                fetch('api.php', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(res => {
                    if(res.success) loadDataFromDB();
                });
            }
        }

        // --- TASKS LOGIC ---

        function openTaskModal(id = null) {
            const modal = document.getElementById('taskModal');
            const form = document.getElementById('taskForm');
            form.reset();

            const projSelect = document.getElementById('task-project');
            projSelect.innerHTML = '';
            db.projects.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.innerText = p.name;
                projSelect.appendChild(opt);
            });

            if (db.projects.length === 0) {
                alert("Сначала создайте проект!");
                closeModal('taskModal');
                return;
            }

            if (id) {
                const task = db.tasks.find(t => t.id == id);
                document.getElementById('task-id').value = task.id;
                document.getElementById('task-desc').value = task.description; // Изменено имя поля
                document.getElementById('task-project').value = task.project_id; // Изменено имя поля
                document.getElementById('task-category').value = task.category;
                document.getElementById('task-time').value = task.time_spent; // Изменено имя поля
                
                // Чекбокс статуса нужно обрабатывать отдельно, если бы он был в модалке, 
                // но у нас статус меняется сразу в таблице.
                
                document.getElementById('taskModalTitle').innerText = "Редактировать задачу";
            } else {
                document.getElementById('task-id').value = '';
                document.getElementById('taskModalTitle').innerText = "Новая задача";
            }
            modal.style.display = 'flex';
        }

        document.getElementById('taskForm').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('task-id').value;
            const formData = new FormData();
            formData.append('action', 'save_task');
            if(id) formData.append('id', id);
            formData.append('projectId', document.getElementById('task-project').value);
            formData.append('desc', document.getElementById('task-desc').value);
            formData.append('category', document.getElementById('task-category').value);
            formData.append('time', document.getElementById('task-time').value);
            // При создании через модалку задача всегда новая (не выполнена)
            formData.append('done', 0); 

            fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if(res.success) {
                    loadDataFromDB();
                    closeModal('taskModal');
                }
            });
        };

        function toggleTask(id) {
            const task = db.tasks.find(t => t.id == id);
            const newStatus = task.is_done == 1 ? 0 : 1;
            
            const formData = new FormData();
            formData.append('action', 'toggle_task');
            formData.append('id', id);
            formData.append('isDone', newStatus);

            fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if(res.success) loadDataFromDB();
            });
        }

        function deleteTask(id) {
            const formData = new FormData();
            formData.append('action', 'delete_task');
            formData.append('id', id);

            fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if(res.success) loadDataFromDB();
            });
        }

        function renderTasks() {
            const tbody = document.getElementById('tasks-table-body');
            const filterProj = document.getElementById('task-filter-project').value;
            const filterStatus = document.getElementById('task-filter-status').value;

            tbody.innerHTML = '';

            db.tasks.forEach(t => {
                if (filterProj !== 'all' && t.project_id != filterProj) return;
                
                // Логика фильтра по статусу
                const isDone = t.is_done == 1;
                if (filterStatus !== 'all') {
                    if (filterStatus === 'done' && !isDone) return;
                    if (filterStatus === 'pending' && isDone) return;
                }

                const proj = db.projects.find(p => p.id == t.project_id);
                const projName = proj ? proj.name : 'Unknown';

                const tr = document.createElement('tr');
                tr.style.opacity = isDone ? '0.6' : '1';
                tr.style.textDecoration = isDone ? 'line-through' : 'none';

                tr.innerHTML = `
                    <td><input type="checkbox" class="status-checkbox" ${isDone ? 'checked' : ''} onchange="toggleTask(${t.id})"></td>
                    <td>${t.description}</td>
                    <td>${projName}</td>
                    <td><span class="kb-tag">${t.category}</span></td>
                    <td>${t.time_spent}</td>
                    <td>
                        <button class="btn btn-outline" style="padding: 5px 10px;" onclick="startFocusMode(${t.id})" title="Режим фокуса"><i class="fas fa-stopwatch"></i></button>
                    </td>
                    <td>
                        <button class="btn btn-outline" style="padding: 5px 10px;" onclick="openTaskModal(${t.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-outline" style="padding: 5px 10px; color: var(--danger);" onclick="deleteTask(${t.id})"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // --- FOCUS MODE (POMODORO) ---
        // Остается почти без изменений, но обновление времени в БД требует AJAX
        let focusTimerInterval;
        let focusTimeLeft = 25 * 60;
        let isFocusRunning = false;
        let currentFocusTaskId = null;

        function startFocusMode(taskId) {
            const task = db.tasks.find(t => t.id == taskId);
            if(!task) return;
            
            currentFocusTaskId = taskId;
            document.getElementById('focus-task-name').innerText = task.description;
            document.getElementById('focus-overlay').style.display = 'flex';
            
            focusTimeLeft = 25 * 60;
            isFocusRunning = false;
            updateFocusDisplay();
            document.getElementById('focus-toggle-btn').innerText = "Старт";
            document.getElementById('focus-toggle-btn').classList.remove('btn-danger');
            document.getElementById('focus-toggle-btn').classList.add('btn-primary');
        }

        function toggleFocusTimer() {
            const btn = document.getElementById('focus-toggle-btn');
            if(isFocusRunning) {
                clearInterval(focusTimerInterval);
                isFocusRunning = false;
                btn.innerText = "Продолжить";
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-primary');
            } else {
                isFocusRunning = true;
                btn.innerText = "Пауза";
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-danger');
                
                focusTimerInterval = setInterval(() => {
                    if(focusTimeLeft > 0) {
                        focusTimeLeft--;
                        updateFocusDisplay();
                    } else {
                        clearInterval(focusTimerInterval);
                        isFocusRunning = false;
                        alert("Время вышло! Отличная работа.");
                        if(currentFocusTaskId) {
                            // Добавляем 0.5 часа к задаче через API
                            const task = db.tasks.find(t => t.id == currentFocusTaskId);
                            if(task) {
                                const newTime = parseFloat(task.time_spent) + 0.5;
                                const formData = new FormData();
                                formData.append('action', 'save_task');
                                formData.append('id', currentFocusTaskId);
                                formData.append('projectId', task.project_id);
                                formData.append('desc', task.description);
                                formData.append('category', task.category);
                                formData.append('time', newTime);
                                formData.append('done', task.is_done);
                                
                                fetch('api.php', { method: 'POST', body: formData })
                                .then(() => loadDataFromDB());
                            }
                        }
                        exitFocusMode();
                    }
                }, 1000);
            }
        }

        function updateFocusDisplay() {
            const m = Math.floor(focusTimeLeft / 60);
            const s = focusTimeLeft % 60;
            document.getElementById('focus-timer').innerText = 
                `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        }

        function exitFocusMode() {
            clearInterval(focusTimerInterval);
            document.getElementById('focus-overlay').style.display = 'none';
            currentFocusTaskId = null;
        }

        // --- DASHBOARD & CHARTS ---
        let financeChartInst = null;
        let tasksChartInst = null;
        let timeFunnelChartInst = null;

        function renderDashboard() {
            document.getElementById('dash-active-projects').innerText = db.projects.length;

            const totalRev = db.projects.reduce((sum, p) => sum + parseFloat(p.revenue), 0);
            const totalExp = db.projects.reduce((sum, p) => sum + parseFloat(p.expenses), 0);
            const totalHoursPlan = db.projects.reduce((sum, p) => sum + parseFloat(p.hours), 0);

            const realRate = totalHoursPlan > 0 ? ((totalRev - totalExp) / totalHoursPlan).toFixed(2) : 0;

            document.getElementById('dash-revenue').innerText = '$' + totalRev.toLocaleString();
            document.getElementById('dash-expenses').innerText = '$' + totalExp.toLocaleString();
            document.getElementById('dash-rate').innerText = '$' + realRate;

            const rateEl = document.getElementById('dash-rate-trend');
            if(realRate < 10) { rateEl.innerText = "Низкая эффективность!"; rateEl.className = "stat-trend trend-down"; }
            else if(realRate < 50) { rateEl.innerText = "Нормально"; rateEl.className = "stat-trend"; }
            else { rateEl.innerText = "Отлично!"; rateEl.className = "stat-trend trend-up"; }

            // Charts
            const ctxFin = document.getElementById('financeChart').getContext('2d');
            const ctxTask = document.getElementById('tasksChart').getContext('2d');
            const ctxTime = document.getElementById('timeFunnelChart').getContext('2d');

            if(financeChartInst) financeChartInst.destroy();
            if(tasksChartInst) tasksChartInst.destroy();
            if(timeFunnelChartInst) timeFunnelChartInst.destroy();

            financeChartInst = new Chart(ctxFin, {
                type: 'bar',
                data: {
                    labels: db.projects.map(p => p.name),
                    datasets: [
                        { label: 'Доход', data: db.projects.map(p => p.revenue), backgroundColor: '#10b981' },
                        { label: 'Расход', data: db.projects.map(p => p.expenses), backgroundColor: '#ef4444' }
                    ]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } }
                }
            });

            const doneCount = db.tasks.filter(t => t.is_done == 1).length;
            const pendingCount = db.tasks.length - doneCount;

            tasksChartInst = new Chart(ctxTask, {
                type: 'doughnut',
                data: {
                    labels: ['Готово', 'В работе'],
                    datasets: [{
                        data: [doneCount, pendingCount],
                        backgroundColor: ['#10b981', '#f3f4f6'],
                        borderColor: ['#059669', '#e5e7eb']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            const timeData = db.projects.map(p => ({ name: p.name, hours: p.hours }));
            timeFunnelChartInst = new Chart(ctxTime, {
                type: 'pie',
                data: {
                    labels: timeData.map(d => d.name),
                    datasets: [{
                        data: timeData.map(d => d.hours),
                        backgroundColor: ['#4f46e5', '#06b6d4', '#8b5cf6', '#d946ef', '#f43f5e', '#f59e0b'],
                        borderWidth: 0
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'right' } }
                }
            });

            // Risk Factors
            const riskContainer = document.getElementById('risk-factors');
            const risks = [];
            db.projects.forEach(p => {
                const profit = parseFloat(p.revenue) - parseFloat(p.expenses);
                const h = parseFloat(p.hours);
                const rate = h > 0 ? profit / h : 0;
                if(rate < 10 && h > 0) risks.push(`⚠️ <b>${p.name}</b>: Низкая ставка ($${rate.toFixed(1)}/ч)`);
                if(profit < 0) risks.push(`🔴 <b>${p.name}</b>: Убыточный проект`);
            });

            if(risks.length === 0) {
                riskContainer.innerHTML = '<p style="color: var(--success);"><i class="fas fa-check-circle"></i> Все проекты в зоне безопасности.</p>';
            } else {
                riskContainer.innerHTML = risks.map(r => `<div style="margin-bottom: 8px; padding: 8px; background: #fef2f2; border-radius: 6px; border-left: 3px solid var(--danger);">${r}</div>`).join('');
            }
        }

        function updateLevel() {
            const xp = db.xp;
            const level = Math.floor(xp / 100) + 1;
            const nextLevelXp = level * 100;
            const progress = xp % 100;

            let title = "Новичок";
            if(level > 5) title = "SEO-Специалист";
            if(level > 10) title = "Team Lead";
            if(level > 20) title = "SEO-Guru";

            document.getElementById('user-level').innerText = `${title} (Lvl ${level})`;
            document.getElementById('xp-progress').innerText = `XP: ${xp} (до след. уровня: ${nextLevelXp - xp})`;
        }

        // --- KNOWLEDGE BASE ---
        function renderKnowledgeBase() {
            const createList = (items, type) => {
                const container = document.getElementById(type);
                container.innerHTML = '';
                items.forEach(item => {
                    const div = document.createElement('div');
                    div.style.marginBottom = '10px';
                    div.style.borderBottom = '1px solid #eee';
                    div.style.paddingBottom = '5px';

                    let btnHtml = '';
                    if(item.time) {
                        btnHtml = `<button class="btn btn-primary" style="padding: 2px 8px; font-size: 0.7rem; float: right;" onclick="quickAddTask('${item.title}', ${item.time})">+ В задачи</button>`;
                    }

                    div.innerHTML = `<div style="font-weight:500;">${item.title} ${btnHtml}</div>`;
                    if(item.time) div.innerHTML += `<div style="font-size:0.8rem; color:#888;">~${item.time} ч</div>`;
                    container.appendChild(div);
                });
            };

            createList(KB_DATA.quickWins, 'kb-quick-wins');
            createList(KB_DATA.antiPatterns, 'kb-antipatterns');
            createList(KB_DATA.audit, 'kb-audit');
            createList(KB_DATA.advanced, 'kb-advanced');
        }

        function quickAddTask(title, time) {
            if(db.projects.length === 0) { alert("Создайте проект!"); return; }
            // Добавляем в первый проект
            const formData = new FormData();
            formData.append('action', 'save_task');
            formData.append('projectId', db.projects[0].id);
            formData.append('desc', title);
            formData.append('category', 'other');
            formData.append('time', time);
            formData.append('done', 0);

            fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if(res.success) {
                    loadDataFromDB();
                    alert(`Задача "${title}" добавлена в проект "${db.projects[0].name}"`);
                }
            });
        }

        // --- AI SIMULATION ---
        function generateAiTip() {
            const tips = [];
            const pending = db.tasks.filter(t => t.is_done == 0).length;
            const lowRateProjs = db.projects.filter(p => {
                const profit = parseFloat(p.revenue) - parseFloat(p.expenses);
                const h = parseFloat(p.hours);
                return h > 0 && (profit / h) < 20;
            });

            if(db.projects.length === 0) {
                tips.push("У вас нет проектов. Создайте первый проект, чтобы начать трекинг!");
            } else if (pending === 0 && db.projects.length > 0) {
                tips.push("Все задачи выполнены? Отлично! Проверьте раздел 'Нестандартные ходы' для роста.");
            } else if (lowRateProjs.length > 0) {
                tips.push(`Внимание: Проект "${lowRateProjs[0].name}" имеет низкую почасовую окупаемость. Пересмотрите задачи или цену.`);
            } else {
                tips.push("Стабильная работа. Не забудьте сделать бэкап данных сегодня.");
            }

            document.querySelector('#ai-suggestion p').innerText = tips[0];
        }

        // --- GSC INTEGRATION ---
        let gscChartInst = null;

        function initGsc() {
            if(db.gsc.clientId) {
                document.getElementById('gsc-client-id').value = db.gsc.clientId;
                document.getElementById('btn-connect-gsc').disabled = false;
            }
        }

        function saveGscSettings() {
            const clientId = document.getElementById('gsc-client-id').value.trim();
            if(!clientId) {
                alert("Введите Client ID");
                return;
            }
            db.gsc.clientId = clientId;
            
            const formData = new FormData();
            formData.append('action', 'save_settings');
            formData.append('key', 'gsc_client_id');
            formData.append('value', clientId);

            fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if(res.success) {
                    document.getElementById('btn-connect-gsc').disabled = false;
                    document.getElementById('gsc-status').innerHTML = '<span style="color: var(--success);">Настройки сохранены!</span>';
                    setTimeout(() => document.getElementById('gsc-status').innerHTML = '', 3000);
                }
            });
        }

        function connectGsc() {
            const clientId = db.gsc.clientId;
            const redirectUri = window.location.href.split('#')[0];
            const scope = 'https://www.googleapis.com/auth/webmasters.readonly ';
            const state = 'seo_manager_state';
            
            const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${clientId}&redirect_uri=${encodeURIComponent(redirectUri)}&response_type=token&scope=${encodeURIComponent(scope)}&state=${state}&access_type=online&prompt=consent`;
            
            const width = 600;
            const height = 700;
            const left = (screen.width / 2) - (width / 2);
            const top = (screen.height / 2) - (height / 2);
            
            const popup = window.open(authUrl, 'Google Login', `width=${width},height=${height},left=${left},top=${top}`);
            
            window.addEventListener('message', function(event) {
                if(event.origin !== window.location.origin) return; 
                if(event.data.type === 'gsc_auth_success') {
                    handleGscToken(event.data.token);
                }
            });

            checkHashForToken();
        }

        function checkHashForToken() {
            const hash = window.location.hash;
            if(hash && hash.includes('access_token')) {
                const params = new URLSearchParams(hash.substring(1));
                const token = params.get('access_token');
                if(token) {
                    handleGscToken(token);
                    history.replaceState(null, null, ' ');
                }
            }
        }

        function handleGscToken(token) {
            db.gsc.token = token;
            
            const formData = new FormData();
            formData.append('action', 'save_settings');
            formData.append('key', 'gsc_token');
            formData.append('value', token);

            fetch('api.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if(res.success) {
                    document.getElementById('gsc-status').innerHTML = '<span style="color: var(--success);">Успешная авторизация! Загрузка данных...</span>';
                    fetchGscData();
                }
            });
        }

        function checkGscAuth() {
            if(db.gsc.token) {
                document.getElementById('gsc-setup-card').style.display = 'none';
                document.getElementById('gsc-dashboard').style.display = 'block';
                fetchGscData();
            } else {
                document.getElementById('gsc-setup-card').style.display = 'block';
                document.getElementById('gsc-dashboard').style.display = 'none';
            }
        }

        function disconnectGsc() {
            db.gsc.token = null;
            db.gsc.siteUrl = null;
            
            const formData = new FormData();
            formData.append('action', 'save_settings');
            formData.append('key', 'gsc_token');
            formData.append('value', '');
            formData.append('key', 'gsc_site_url'); // Упрощенно очищаем
            formData.append('value', '');

            fetch('api.php', { method: 'POST', body: formData })
            .then(() => location.reload());
        }

        async function fetchGscData() {
            if(!db.gsc.token) return;

            try {
                const sitesRes = await fetch(' https://www.googleapis.com/webmasters/v3/sites?access_token=' + db.gsc.token);
                const sitesData = await sitesRes.json();
                
                if(sitesData.error) throw new Error(sitesData.error.message);

                if(!sitesData.siteEntry || sitesData.siteEntry.length === 0) {
                    document.getElementById('gsc-insights').innerHTML = "Нет сайтов в GSC.";
                    return;
                }

                let siteUrl = db.gsc.siteUrl || sitesData.siteEntry[0].siteUrl;
                db.gsc.siteUrl = siteUrl;
                
                // Сохраняем выбранный сайт
                const formData = new FormData();
                formData.append('action', 'save_settings');
                formData.append('key', 'gsc_site_url');
                formData.append('value', siteUrl);
                fetch('api.php', { method: 'POST', body: formData });

                document.getElementById('gsc-site-name').innerText = siteUrl;

                const endDate = new Date().toISOString().split('T')[0];
                const startDate = new Date(Date.now() - 90 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];

                const reportBody = {
                    startDate: startDate,
                    endDate: endDate,
                    dimensions: ['date'],
                    rowLimit: 90
                };

                const reportRes = await fetch(` https://www.googleapis.com/webmasters/v3/sites/ ${encodeURIComponent(siteUrl)}/searchAnalytics/query?access_token=${db.gsc.token}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(reportBody)
                });

                const reportData = await reportRes.json();
                if(reportData.error) throw new Error(reportData.error.message);

                renderGscDashboard(reportData);

                const queryBody = {
                    startDate: startDate,
                    endDate: endDate,
                    dimensions: ['query'],
                    rowLimit: 20,
                    startRow: 0
                };
                
                const queryRes = await fetch(`https://www.googleapis.com/webmasters/v3/sites/ ${encodeURIComponent(siteUrl)}/searchAnalytics/query?access_token=${db.gsc.token}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(queryBody)
                });
                const queryData = await queryRes.json();
                renderGscQueries(queryData);

            } catch (err) {
                console.error(err);
                document.getElementById('gsc-status').innerHTML = `<span style="color: var(--danger);">Ошибка: ${err.message}. Попробуйте переподключиться.</span>`;
                disconnectGsc();
            }
        }

        function renderGscDashboard(data) {
            if(!data.rows) return;

            let totalClicks = 0;
            let totalImpressions = 0;
            let sumCtr = 0;
            let sumPos = 0;

            const labels = [];
            const clicksData = [];
            const impressionsData = [];

            data.rows.forEach(row => {
                totalClicks += row.clicks;
                totalImpressions += row.impressions;
                sumCtr += row.ctr;
                sumPos += row.position;

                labels.push(row.keys[0]);
                clicksData.push(row.clicks);
                impressionsData.push(row.impressions);
            });

            const avgCtr = data.rows.length ? (sumCtr / data.rows.length) * 100 : 0;
            const avgPos = data.rows.length ? (sumPos / data.rows.length) : 0;

            document.getElementById('gsc-clicks').innerText = Math.round(totalClicks).toLocaleString();
            document.getElementById('gsc-impressions').innerText = Math.round(totalImpressions).toLocaleString();
            document.getElementById('gsc-ctr').innerText = avgCtr.toFixed(1) + '%';
            document.getElementById('gsc-position').innerText = avgPos.toFixed(1);

            const ctx = document.getElementById('gscTrafficChart').getContext('2d');
            if(gscChartInst) gscChartInst.destroy();

            gscChartInst = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Клики', data: clicksData, borderColor: '#4f46e5', tension: 0.3, fill: false },
                        { label: 'Показы', data: impressionsData, borderColor: '#10b981', tension: 0.3, fill: false }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            const insightsDiv = document.getElementById('gsc-insights');
            let insightsHtml = '';
            
            const lowCtrRows = data.rows.filter(r => r.position < 10 && r.ctr < 0.02);
            if(lowCtrRows.length > 0) {
                insightsHtml += `<div class="ai-tip" style="margin-bottom:10px;"><b>Quick Win:</b> Найдено ${lowCtrRows.length} запросов с высокой позицией, но низким CTR. Попробуйте улучшить Title/Description.</div>`;
            } else {
                insightsHtml += `<div style="color: var(--success);">Отличные показатели CTR!</div>`;
            }
            insightsDiv.innerHTML = insightsHtml;
        }

        function renderGscQueries(data) {
            const tbody = document.querySelector('#gsc-queries-table tbody');
            tbody.innerHTML = '';
            if(!data.rows) return;

            data.rows.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.keys[0]}</td>
                    <td>${row.position.toFixed(1)}</td>
                    <td>${(row.ctr * 100).toFixed(1)}%</td>
                    <td>
                        <button class="btn btn-primary" style="padding: 2px 8px; font-size: 0.7rem;" onclick="quickAddTask('Оптимизировать сниппет для: ${row.keys[0]}', 0.5)">+ Задача</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

    </script>
</body>
</html>