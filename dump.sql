--
-- PostgreSQL database dump
--

-- Dumped from database version 11.5
-- Dumped by pg_dump version 11.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: adminpack; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS adminpack WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION adminpack; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION adminpack IS 'administrative functions for PostgreSQL';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: budgets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.budgets (
    budgetid integer NOT NULL,
    username character varying,
    budgetname character varying,
    budgetamount numeric,
    budgetcolor character varying
);


ALTER TABLE public.budgets OWNER TO postgres;

--
-- Name: budgets_budgetid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.budgets_budgetid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.budgets_budgetid_seq OWNER TO postgres;

--
-- Name: budgets_budgetid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.budgets_budgetid_seq OWNED BY public.budgets.budgetid;


--
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    categoryid integer NOT NULL,
    username character varying,
    categoryname character varying,
    categorybudget integer DEFAULT 0,
    categorycolor character varying
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- Name: categories_categoryid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_categoryid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_categoryid_seq OWNER TO postgres;

--
-- Name: categories_categoryid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_categoryid_seq OWNED BY public.categories.categoryid;


--
-- Name: colors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.colors (
    colorid integer NOT NULL,
    colorname character varying,
    colorhex character varying,
    colortaken boolean,
    username character varying
);


ALTER TABLE public.colors OWNER TO postgres;

--
-- Name: colors_colorid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.colors_colorid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.colors_colorid_seq OWNER TO postgres;

--
-- Name: colors_colorid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.colors_colorid_seq OWNED BY public.colors.colorid;


--
-- Name: expenses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.expenses (
    expenseid integer NOT NULL,
    budgetid integer NOT NULL,
    expensename character varying NOT NULL,
    expenseamount numeric NOT NULL,
    expensedate date NOT NULL,
    username character varying
);


ALTER TABLE public.expenses OWNER TO postgres;

--
-- Name: expenses_expenseid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.expenses_expenseid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.expenses_expenseid_seq OWNER TO postgres;

--
-- Name: expenses_expenseid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.expenses_expenseid_seq OWNED BY public.expenses.expenseid;


--
-- Name: groupbudgets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groupbudgets (
    budgetid integer NOT NULL,
    groupingid integer,
    budgetname character varying,
    budgetamount numeric,
    budgetcolor character varying
);


ALTER TABLE public.groupbudgets OWNER TO postgres;

--
-- Name: groupbudgets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.groupbudgets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groupbudgets_id_seq OWNER TO postgres;

--
-- Name: groupbudgets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.groupbudgets_id_seq OWNED BY public.groupbudgets.budgetid;


--
-- Name: groupcolors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groupcolors (
    colorid integer DEFAULT nextval('public.colors_colorid_seq'::regclass) NOT NULL,
    colorname character varying,
    colorhex character varying,
    colortaken boolean,
    groupingid integer
);


ALTER TABLE public.groupcolors OWNER TO postgres;

--
-- Name: groupexpenses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groupexpenses (
    expenseid integer NOT NULL,
    budgetid integer,
    expensename character varying,
    expenseamount numeric,
    expensedate date,
    groupingid integer,
    username character varying
);


ALTER TABLE public.groupexpenses OWNER TO postgres;

--
-- Name: groupexpenses_expenseid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.groupexpenses_expenseid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groupexpenses_expenseid_seq OWNER TO postgres;

--
-- Name: groupexpenses_expenseid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.groupexpenses_expenseid_seq OWNED BY public.groupexpenses.expenseid;


--
-- Name: groupreminders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groupreminders (
    reminderid integer NOT NULL,
    budgetid integer,
    remindername character varying,
    reminderamount numeric,
    reminderdate date,
    reminderdone boolean,
    groupingid integer,
    username character varying
);


ALTER TABLE public.groupreminders OWNER TO postgres;

--
-- Name: groupreminders_reminderid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.groupreminders_reminderid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groupreminders_reminderid_seq OWNER TO postgres;

--
-- Name: groupreminders_reminderid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.groupreminders_reminderid_seq OWNED BY public.groupreminders.reminderid;


--
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.groups (
    id integer NOT NULL,
    groupingid integer,
    adminusername character varying,
    groupname character varying,
    groupicon character varying,
    memberusername character varying,
    maxbudget numeric DEFAULT 0,
    remindersetting1 boolean DEFAULT true,
    remindersetting2 boolean DEFAULT false
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- Name: groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.groups_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groups_id_seq OWNER TO postgres;

--
-- Name: groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.groups_id_seq OWNED BY public.groups.id;


--
-- Name: notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifications (
    id integer NOT NULL,
    notificationtitle character varying,
    notificationmessage character varying,
    notificationdate date,
    notificationtype character varying,
    notificationstatus character varying,
    recipientusername character varying,
    senderusername character varying,
    bolddata character varying,
    groupingid integer
);


ALTER TABLE public.notifications OWNER TO postgres;

--
-- Name: COLUMN notifications.groupingid; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.notifications.groupingid IS 'for invitation notification';


--
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notifications_id_seq OWNER TO postgres;

--
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- Name: reminders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reminders (
    reminderid integer NOT NULL,
    budgetid integer NOT NULL,
    remindername character varying(255) NOT NULL,
    reminderamount numeric NOT NULL,
    reminderdate date NOT NULL,
    reminderdone boolean DEFAULT false NOT NULL,
    username character varying NOT NULL
);


ALTER TABLE public.reminders OWNER TO postgres;

--
-- Name: reminder_reminderid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reminder_reminderid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reminder_reminderid_seq OWNER TO postgres;

--
-- Name: reminder_reminderid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reminder_reminderid_seq OWNED BY public.reminders.reminderid;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    "userID" integer NOT NULL,
    email character varying(255) NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    income numeric DEFAULT 0,
    "budgetRecurrence" integer DEFAULT 1,
    "reminderSetting1" boolean DEFAULT true,
    "reminderSetting2" boolean DEFAULT false
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_userID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."users_userID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."users_userID_seq" OWNER TO postgres;

--
-- Name: users_userID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."users_userID_seq" OWNED BY public.users."userID";


--
-- Name: budgets budgetid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.budgets ALTER COLUMN budgetid SET DEFAULT nextval('public.budgets_budgetid_seq'::regclass);


--
-- Name: categories categoryid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN categoryid SET DEFAULT nextval('public.categories_categoryid_seq'::regclass);


--
-- Name: colors colorid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.colors ALTER COLUMN colorid SET DEFAULT nextval('public.colors_colorid_seq'::regclass);


--
-- Name: expenses expenseid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.expenses ALTER COLUMN expenseid SET DEFAULT nextval('public.expenses_expenseid_seq'::regclass);


--
-- Name: groupbudgets budgetid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groupbudgets ALTER COLUMN budgetid SET DEFAULT nextval('public.groupbudgets_id_seq'::regclass);


--
-- Name: groupexpenses expenseid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groupexpenses ALTER COLUMN expenseid SET DEFAULT nextval('public.groupexpenses_expenseid_seq'::regclass);


--
-- Name: groupreminders reminderid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groupreminders ALTER COLUMN reminderid SET DEFAULT nextval('public.groupreminders_reminderid_seq'::regclass);


--
-- Name: groups id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups ALTER COLUMN id SET DEFAULT nextval('public.groups_id_seq'::regclass);


--
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- Name: reminders reminderid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reminders ALTER COLUMN reminderid SET DEFAULT nextval('public.reminder_reminderid_seq'::regclass);


--
-- Name: users userID; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN "userID" SET DEFAULT nextval('public."users_userID_seq"'::regclass);


--
-- Data for Name: budgets; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.budgets VALUES (43, 'evan', 'Gifts', 100.00, 'watermelon-red');
INSERT INTO public.budgets VALUES (45, 'evan', 'Travel', 50.00, 'dark-blue');
INSERT INTO public.budgets VALUES (42, 'evan', 'Groceries', 70.00, 'lime');
INSERT INTO public.budgets VALUES (46, 'evan', 'Bills', 350.00, 'cyan');
INSERT INTO public.budgets VALUES (47, 'evan', 'Food', 300.00, 'mustard');
INSERT INTO public.budgets VALUES (48, 'evan', 'Misc', 100.00, 'lavender');


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: colors; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.colors VALUES (176, 'hot-pink', '#dc6372', false, 'evan');
INSERT INTO public.colors VALUES (177, 'mud', '#c18f6b', false, 'evan');
INSERT INTO public.colors VALUES (178, 'baby-blue', '#73aad8', false, 'evan');
INSERT INTO public.colors VALUES (180, 'tangerine', '#fa9a4c', false, 'evan');
INSERT INTO public.colors VALUES (171, 'watermelon-red', '#e97877', true, 'evan');
INSERT INTO public.colors VALUES (175, 'dark-blue', '#348c9f', true, 'evan');
INSERT INTO public.colors VALUES (173, 'lime', '#dfd277', true, 'evan');
INSERT INTO public.colors VALUES (174, 'cyan', '#4ccead', true, 'evan');
INSERT INTO public.colors VALUES (172, 'mustard', '#f9d677', true, 'evan');
INSERT INTO public.colors VALUES (179, 'lavender', '#c785da', true, 'evan');
INSERT INTO public.colors VALUES (191, 'watermelon-red', '#e97877', false, 'chevs');
INSERT INTO public.colors VALUES (192, 'mustard', '#f9d677', false, 'chevs');
INSERT INTO public.colors VALUES (193, 'lime', '#dfd277', false, 'chevs');
INSERT INTO public.colors VALUES (194, 'cyan', '#4ccead', false, 'chevs');
INSERT INTO public.colors VALUES (195, 'dark-blue', '#348c9f', false, 'chevs');
INSERT INTO public.colors VALUES (196, 'hot-pink', '#dc6372', false, 'chevs');
INSERT INTO public.colors VALUES (197, 'mud', '#c18f6b', false, 'chevs');
INSERT INTO public.colors VALUES (198, 'baby-blue', '#73aad8', false, 'chevs');
INSERT INTO public.colors VALUES (199, 'lavender', '#c785da', false, 'chevs');
INSERT INTO public.colors VALUES (200, 'tangerine', '#fa9a4c', false, 'chevs');
INSERT INTO public.colors VALUES (211, 'watermelon-red', '#e97877', false, 'jane');
INSERT INTO public.colors VALUES (212, 'mustard', '#f9d677', false, 'jane');
INSERT INTO public.colors VALUES (213, 'lime', '#dfd277', false, 'jane');
INSERT INTO public.colors VALUES (214, 'cyan', '#4ccead', false, 'jane');
INSERT INTO public.colors VALUES (215, 'dark-blue', '#348c9f', false, 'jane');
INSERT INTO public.colors VALUES (216, 'hot-pink', '#dc6372', false, 'jane');
INSERT INTO public.colors VALUES (217, 'mud', '#c18f6b', false, 'jane');
INSERT INTO public.colors VALUES (218, 'baby-blue', '#73aad8', false, 'jane');
INSERT INTO public.colors VALUES (219, 'lavender', '#c785da', false, 'jane');
INSERT INTO public.colors VALUES (220, 'tangerine', '#fa9a4c', false, 'jane');


--
-- Data for Name: expenses; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.expenses VALUES (143, 47, 'vestibulum proin eu', 7.00, '2019-12-24', 'evan');
INSERT INTO public.expenses VALUES (144, 45, 'erat nulla tempus', 17.00, '2019-12-09', 'evan');
INSERT INTO public.expenses VALUES (145, 46, 'potenti', 19.00, '2019-12-10', 'evan');
INSERT INTO public.expenses VALUES (146, 45, 'libero rutrum ac', 12.00, '2019-12-13', 'evan');
INSERT INTO public.expenses VALUES (147, 43, 'lacus', 14.00, '2019-12-25', 'evan');
INSERT INTO public.expenses VALUES (148, 48, 'lacus at velit', 6.00, '2019-12-15', 'evan');
INSERT INTO public.expenses VALUES (149, 43, 'nullam varius nulla', 12.00, '2019-12-07', 'evan');
INSERT INTO public.expenses VALUES (150, 42, 'vulputate nonummy', 5.00, '2019-12-12', 'evan');
INSERT INTO public.expenses VALUES (151, 45, 'consectetuer', 10.00, '2019-12-09', 'evan');
INSERT INTO public.expenses VALUES (152, 43, 'in est risus', 8.00, '2019-12-06', 'evan');
INSERT INTO public.expenses VALUES (153, 46, 'libero convallis', 7.00, '2019-12-03', 'evan');
INSERT INTO public.expenses VALUES (154, 47, 'amet', 12.00, '2019-12-17', 'evan');
INSERT INTO public.expenses VALUES (155, 45, 'neque duis bibendum', 8.00, '2019-12-17', 'evan');
INSERT INTO public.expenses VALUES (156, 48, 'orci', 9.00, '2019-12-14', 'evan');
INSERT INTO public.expenses VALUES (157, 48, 'faucibus accumsan odio', 10.00, '2019-12-26', 'evan');
INSERT INTO public.expenses VALUES (158, 42, 'ante', 11.00, '2019-12-16', 'evan');
INSERT INTO public.expenses VALUES (159, 46, 'molestie sed justo', 13.00, '2019-12-10', 'evan');
INSERT INTO public.expenses VALUES (160, 47, 'lectus', 7.00, '2019-12-02', 'evan');
INSERT INTO public.expenses VALUES (161, 43, 'elit proin', 13.00, '2019-12-18', 'evan');
INSERT INTO public.expenses VALUES (162, 47, 'montes nascetur ridiculus', 13.00, '2019-12-07', 'evan');
INSERT INTO public.expenses VALUES (163, 42, 'risus dapibus augue', 20.00, '2019-12-15', 'evan');
INSERT INTO public.expenses VALUES (164, 48, 'erat', 8.00, '2019-12-21', 'evan');
INSERT INTO public.expenses VALUES (165, 47, 'justo eu', 10.00, '2019-12-01', 'evan');
INSERT INTO public.expenses VALUES (166, 43, 'eget vulputate ut', 18.00, '2019-12-05', 'evan');
INSERT INTO public.expenses VALUES (167, 47, 'libero', 11.00, '2019-12-12', 'evan');
INSERT INTO public.expenses VALUES (168, 42, 'id ligula suspendisse', 7.00, '2019-12-25', 'evan');
INSERT INTO public.expenses VALUES (169, 46, 'sapien non mi', 53.00, '2019-12-27', 'evan');
INSERT INTO public.expenses VALUES (171, 47, 'feugiat et eros', 6.00, '2019-12-08', 'evan');
INSERT INTO public.expenses VALUES (172, 42, 'vel nulla eget', 15.00, '2019-12-04', 'evan');
INSERT INTO public.expenses VALUES (173, 47, 'facilisi cras non', 20.00, '2019-12-23', 'evan');
INSERT INTO public.expenses VALUES (174, 48, 'eu sapien cursus', 10.00, '2019-12-20', 'evan');
INSERT INTO public.expenses VALUES (175, 46, 'pharetra magna', 30.00, '2019-12-01', 'evan');
INSERT INTO public.expenses VALUES (176, 42, 'in faucibus', 17.00, '2019-12-11', 'evan');
INSERT INTO public.expenses VALUES (177, 47, 'sociis natoque', 9.00, '2019-12-28', 'evan');
INSERT INTO public.expenses VALUES (178, 47, 'sed', 7.00, '2019-12-22', 'evan');
INSERT INTO public.expenses VALUES (180, 42, 'metus', 12.00, '2019-12-30', 'evan');
INSERT INTO public.expenses VALUES (179, 47, 'donec diam', 8.00, '2019-12-29', 'evan');
INSERT INTO public.expenses VALUES (181, 46, 'nullam', 60.00, '2019-12-31', 'evan');
INSERT INTO public.expenses VALUES (182, 47, 'ac tellus', 5.00, '2019-12-03', 'evan');
INSERT INTO public.expenses VALUES (183, 47, 'est risus auctor', 4.5, '2019-12-08', 'evan');


--
-- Data for Name: groupbudgets; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.groupbudgets VALUES (7, 2, 'Groceries', 200.00, 'lime');
INSERT INTO public.groupbudgets VALUES (8, 2, 'Bills', 100.00, 'baby-blue');


--
-- Data for Name: groupcolors; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.groupcolors VALUES (181, 'watermelon-red', '#e97877', false, 1);
INSERT INTO public.groupcolors VALUES (182, 'mustard', '#f9d677', false, 1);
INSERT INTO public.groupcolors VALUES (183, 'lime', '#dfd277', false, 1);
INSERT INTO public.groupcolors VALUES (184, 'cyan', '#4ccead', false, 1);
INSERT INTO public.groupcolors VALUES (185, 'dark-blue', '#348c9f', false, 1);
INSERT INTO public.groupcolors VALUES (186, 'hot-pink', '#dc6372', false, 1);
INSERT INTO public.groupcolors VALUES (187, 'mud', '#c18f6b', false, 1);
INSERT INTO public.groupcolors VALUES (188, 'baby-blue', '#73aad8', false, 1);
INSERT INTO public.groupcolors VALUES (189, 'lavender', '#c785da', false, 1);
INSERT INTO public.groupcolors VALUES (190, 'tangerine', '#fa9a4c', false, 1);
INSERT INTO public.groupcolors VALUES (201, 'watermelon-red', '#e97877', false, 2);
INSERT INTO public.groupcolors VALUES (202, 'mustard', '#f9d677', false, 2);
INSERT INTO public.groupcolors VALUES (204, 'cyan', '#4ccead', false, 2);
INSERT INTO public.groupcolors VALUES (205, 'dark-blue', '#348c9f', false, 2);
INSERT INTO public.groupcolors VALUES (206, 'hot-pink', '#dc6372', false, 2);
INSERT INTO public.groupcolors VALUES (207, 'mud', '#c18f6b', false, 2);
INSERT INTO public.groupcolors VALUES (209, 'lavender', '#c785da', false, 2);
INSERT INTO public.groupcolors VALUES (210, 'tangerine', '#fa9a4c', false, 2);
INSERT INTO public.groupcolors VALUES (203, 'lime', '#dfd277', true, 2);
INSERT INTO public.groupcolors VALUES (208, 'baby-blue', '#73aad8', true, 2);


--
-- Data for Name: groupexpenses; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.groupexpenses VALUES (14, 7, 'in felis', 10.00, '2019-12-01', 2, 'evan');
INSERT INTO public.groupexpenses VALUES (15, 8, 'blandit', 80.00, '2019-12-10', 2, 'evan');
INSERT INTO public.groupexpenses VALUES (17, 7, 'feugiat et eros', 53.00, '2019-12-17', 2, 'chevs');
INSERT INTO public.groupexpenses VALUES (18, 8, 'consectetuer', 45.00, '2019-12-25', 2, 'chevs');
INSERT INTO public.groupexpenses VALUES (19, 7, 'ac tellus', 30.00, '2019-12-20', 2, 'evan');
INSERT INTO public.groupexpenses VALUES (20, 7, 'erat nulla tempus', 37.00, '2019-12-31', 2, 'evan');


--
-- Data for Name: groupreminders; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.groupreminders VALUES (4, 7, 'Buy pizzas', 50.00, '2019-12-24', false, 2, 'evan');


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.groups VALUES (39, 1, 'evan', 'Familia', '../assets/icons/icon-3.png', 'evan', 0, true, false);
INSERT INTO public.groups VALUES (40, 1, 'evan', 'Familia', '../assets/icons/icon-3.png', 'chevs', 0, true, false);
INSERT INTO public.groups VALUES (41, 2, 'chevs', 'Hostel', '../assets/icons/icon-1.png', 'chevs', 600.00, true, false);
INSERT INTO public.groups VALUES (43, 2, 'chevs', 'Hostel', '../assets/icons/icon-1.png', 'evan', 600.00, true, false);


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.notifications VALUES (49, 'Declined to join group', 'jane declined to join <b>Hostel</b>', '2020-01-29', 'Decline', 'SENT', 'evan', 'jane', 'Hostel', 2);


--
-- Data for Name: reminders; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.reminders VALUES (69, 46, 'Pay phone bill', 53.00, '2020-01-28', false, 'evan');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (53, 'evan@mail.com', 'evan', '123', 1000.00, 1, true, false);
INSERT INTO public.users VALUES (54, 'chevs@mail.com', 'chevs', '123', 0, 1, true, false);
INSERT INTO public.users VALUES (55, 'jane@mail.com', 'jane', '123', 0, 1, true, false);


--
-- Name: budgets_budgetid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.budgets_budgetid_seq', 48, true);


--
-- Name: categories_categoryid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_categoryid_seq', 98, true);


--
-- Name: colors_colorid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.colors_colorid_seq', 220, true);


--
-- Name: expenses_expenseid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.expenses_expenseid_seq', 183, true);


--
-- Name: groupbudgets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.groupbudgets_id_seq', 8, true);


--
-- Name: groupexpenses_expenseid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.groupexpenses_expenseid_seq', 20, true);


--
-- Name: groupreminders_reminderid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.groupreminders_reminderid_seq', 4, true);


--
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.groups_id_seq', 43, true);


--
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifications_id_seq', 49, true);


--
-- Name: reminder_reminderid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reminder_reminderid_seq', 69, true);


--
-- Name: users_userID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."users_userID_seq"', 55, true);


--
-- Name: budgets budgets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.budgets
    ADD CONSTRAINT budgets_pkey PRIMARY KEY (budgetid);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (categoryid);


--
-- Name: colors colors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.colors
    ADD CONSTRAINT colors_pkey PRIMARY KEY (colorid);


--
-- Name: expenses expenses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_pkey PRIMARY KEY (expenseid);


--
-- Name: groupbudgets groupbudgets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groupbudgets
    ADD CONSTRAINT groupbudgets_pkey PRIMARY KEY (budgetid);


--
-- Name: groupexpenses groupexpenses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groupexpenses
    ADD CONSTRAINT groupexpenses_pkey PRIMARY KEY (expenseid);


--
-- Name: groupreminders groupreminders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groupreminders
    ADD CONSTRAINT groupreminders_pkey PRIMARY KEY (reminderid);


--
-- Name: groups groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: reminders reminder_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reminders
    ADD CONSTRAINT reminder_pkey PRIMARY KEY (reminderid);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY ("userID");


--
-- PostgreSQL database dump complete
--

