<div class="row mb-3 border-bottom">
    <div class="col-12 text-end">
        <button class="btn btn-light" id="generate-grid">Пересоздать сетку</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-stage-1-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-stage-1" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">Отборочные
                        </button>
                        <button class="nav-link" id="nav-stage-2-tab" data-bs-toggle="tab" data-bs-target="#nav-stage-2"
                                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Плей-офф
                        </button>
                        <button class="nav-link" id="nav-stage-3-tab" data-bs-toggle="tab" data-bs-target="#nav-stage-3"
                                type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Финал
                        </button>
                    </div>
                </nav>
            </div>
        </div>
        <div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-stage-1" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-8" id="stage-1-table">
                        </div>
                        <div class="col-4" id="stage-1-scorelist">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-stage-2" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row">
                        <div class="col-12" id="stage-2-table">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-stage-3" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="row">
                        <div class="col-12" id="stage-3-table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" defer>
    function renderCompetition(data) {
        const divisions = data.divisions ?? undefined
        const grids = data.grids ?? undefined

        if (!divisions || !grids) return

        if (grids.hasOwnProperty('roundrobin')) {
            const grid = grids.roundrobin;

            for (let key in grid.table) {
                const table = document.getElementById('stage-1-table');
                const tbl = document.getElementById('table-tpl').cloneNode(true);
                tbl.content.querySelector('table').classList.add(`table-hover`, `table-bordered`);
                const thead = tbl.content.querySelector('thead')
                const sl = grid.table[key]
                const division = divisions.filter(item => item.id === parseInt(key))

                if (division.length === 0) continue;

                let header = document.createElement('tr');
                header.innerHTML = `<th colspan="${sl.length + 1}" class="text-center">${division[0].name}</th>`
                thead.appendChild(header)

                header = document.createElement('tr');
                header.innerHTML = `<th class="bg-light">&nbsp;</th>`

                sl.reduce((acc, curr) => {
                    if(acc) {
                        header.innerHTML += `<th>${acc.name}</th>`
                    }

                    header.innerHTML += `<th>${curr.name}</th>`
                })

                thead.appendChild(header)

                sl.forEach((item, ind) => {
                    let body = document.createElement('tr');
                    body.innerHTML = `<td>${item.name}</td>`

                    item.games.forEach((gItem, gInd) => {
                        if (ind === gInd) {
                            body.innerHTML += `<td class="bg-light">&nbsp;</td>`
                        }
                        switch (true) {
                            case gItem.left_score > gItem.right_score:
                                className = 'bg-success bg-gradient';
                                break;
                            case gItem.left_score < gItem.right_score:
                                className = 'bg-danger bg-gradient';
                                break;
                            default:
                                className = '';
                        }

                        if(gItem.release) {
                            body.innerHTML += `<td class="${className}">${gItem.left_score}-${gItem.right_score}</td>`
                        } else {
                            body.innerHTML += `<td class="">&nbsp;</td>`
                        }
                    })

                    if(ind === (sl.length - 1)) {
                        body.innerHTML += `<td class="bg-light">&nbsp;</td>`
                    }

                    tbl.content.querySelector('tbody').appendChild(body)
                })
                table.appendChild(document.importNode(tbl.content, true))

            }

            for (let key in grid.scorelists) {
                const scorelist = document.getElementById('stage-1-scorelist');
                const tbl = document.getElementById('table-tpl').cloneNode(true);
                const thead = tbl.content.querySelector('thead')
                const sl = grid.scorelists[key]
                const division = divisions.filter(item => item.id === parseInt(key))

                if (division.length === 0) continue;

                let header = document.createElement('tr');
                header.innerHTML = `<th colspan="2" class="text-center">${division[0].name}</th>`
                thead.appendChild(header)

                header = document.createElement('tr');
                header.innerHTML = `<th>Команда</th><th>Очки</th>`
                thead.appendChild(header)

                sl.forEach((item, ind) => {
                    let body = document.createElement('tr');
                    body.innerHTML = `<td class="${ind < 2 ? 'table-active' : ''}">${item.name}</td><td>${item.score}</td>`
                    tbl.content.querySelector('tbody').appendChild(body)
                })
                scorelist.appendChild(document.importNode(tbl.content, true))
            }
        }
    }

    __Api.get('grid')
        .then((data) => {
            renderCompetition(data)
        })

    $('#generate-grid').on('click', function (e) {
        e.preventDefault()

        __Api.get('grid/generate')
            .then((data) => {
                renderCompetition(data)
            })

        return false
    })
</script>
