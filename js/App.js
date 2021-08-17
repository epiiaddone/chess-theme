import $ from 'jquery';

//add-remove
import LessonAddRemoveAjax from './modules/add-remove/LessonAddRemoveAjax';
import VisAddRemoveAjax from './modules/add-remove/VisAddRemoveAjax';
import RememberAddRemoveAjax from './modules/add-remove/RememberAddRemoveAjax';
import TacticsAddRemoveAjax from './modules/add-remove/TacticsAddRemoveAjax';

//non-data
import FrontChart from './modules/non-data/FrontChart';
import Countdown from './modules/non-data/Countdown';
import ShowSolution from './modules/non-data/ShowSolution';
//import MailContent from './modules/non-data/MailContent';
import VisShow from './modules/non-data/VisShow';
import Remember from './modules/non-data/Remember';
import Chart1 from './modules/non-data/Chart1';
import CookieBanner from './modules/non-data/CookieBanner';
import TacticsDD from './modules/non-data/TacticsDD';
//import Nav from './modules/non-data/Nav';
//import ReviewSummary from './modules/non-data/ReviewSummary';

//profile
import ResetReviewsAjax from './modules/profile/ResetReviews';

//reports
import QuestionReportAjax from './modules/reports/QuestionReportAjax';
import VisReportAjax from './modules/reports/VisReportAjax';
import TacticReportAjax from './modules/reports/TacticReportAjax';
import LessonReportAjax from './modules/reports/LessonReportAjax';
import RememberReportAjax from './modules/reports/RememberReportAjax';

//reviews
import UserQuestionReviewAjax from './modules/reviews/UserQuestionReviewAjax';
import UserVisReviewAjax from './modules/reviews/UserVisReviewAjax';
import UserTacticReviewAjax from './modules/reviews/UserTacticReviewAjax';


//reviews-outside
import UserTacticAjax from './modules/reviews-outside/UserTacticAjax';

//add-remove
var lessonAddRemoveAjax = new LessonAddRemoveAjax();
var visAddRemoveAjax = new VisAddRemoveAjax();
var rememberAddRemoveAjax = new RememberAddRemoveAjax();
var tacticsAddRemoveAjax = new TacticsAddRemoveAjax();

//non-data
var frontChart = new FrontChart();
var countdown = new Countdown();
var shoSolution = new ShowSolution();
//var mailContent = new MailContent();
var visShow = new VisShow();
var remember = new Remember();
var chart1 = new Chart1();
var cookieBanner = new CookieBanner();
var tacticsDD = new TacticsDD();
//var nav = new Nav();
//var reviewSummary = new ReviewSummary();

//Profile
var resetReviewsAjax = new ResetReviewsAjax();

//reports
var questionReportAjax = new QuestionReportAjax();
var visReportAjax = new VisReportAjax();
var tacticReportAjax = new TacticReportAjax();
var lessonReportAjax = new LessonReportAjax();
var rememberReportAjax = new RememberReportAjax();

//reviews
var userQuestionReviewAjax = new UserQuestionReviewAjax();
var userVisReviewAjax = new UserVisReviewAjax();
var userTacticReviewAjax = new UserTacticReviewAjax();

//reviews-outside
var userTacticAjax = new UserTacticAjax();
