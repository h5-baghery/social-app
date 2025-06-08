import './bootstrap';
import Search from './live-search';
import '../css/app.css';


if (document.querySelector(".header-search-icon")) {
    new Search();
}