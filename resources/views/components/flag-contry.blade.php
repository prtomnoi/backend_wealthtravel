<div class="dropdown">
    <a href="javascript:;" class="btn bg-gradient-dark dropdown-toggle " data-bs-toggle="dropdown"
        id="navbarDropdownMenuLink2">
        <img src="{{ asset('assets/img/flag/united-kingdom-flag-png-large.png') }}" height="25" width="35"
            id="imageFlagDrowdown" />
        Flag
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
        <li>
            <a class="dropdown-item" href="javascript:;" id="en" onclick="changeLange(this)">
                <img src="{{ asset('assets/img/flag/united-kingdom-flag-png-large.png') }}" height="25"
                    width="35" />
                English
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="javascript:;" id="th" onclick="changeLange(this)">
                <img src="{{ asset('assets/img/flag/thailand-flag-png-large.png') }}" height="25" width="35" />
                Thai
            </a>
        </li>
    </ul>
    <input type="text" class="d-none" name="lange" id="lange" value="en">
</div>
