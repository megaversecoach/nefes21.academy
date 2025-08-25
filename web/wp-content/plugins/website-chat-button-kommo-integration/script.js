function json(url) {
    return fetch(url).then(res => res.json());
}
