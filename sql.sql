PGDMP         "                x            postgres    11.5    12.2 ^    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    13012    postgres    DATABASE     �   CREATE DATABASE postgres WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
    DROP DATABASE postgres;
                postgres    false            �           0    0    DATABASE postgres    COMMENT     N   COMMENT ON DATABASE postgres IS 'default administrative connection database';
                   postgres    false    2966                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   postgres    false    4            �            1259    16690    budgets    TABLE     �   CREATE TABLE public.budgets (
    budgetid integer NOT NULL,
    username character varying,
    budgetname character varying,
    budgetamount numeric,
    budgetcolor character varying,
    budgetdate date
);
    DROP TABLE public.budgets;
       public            postgres    false    4            �            1259    16688    budgets_budgetid_seq    SEQUENCE     �   CREATE SEQUENCE public.budgets_budgetid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.budgets_budgetid_seq;
       public          postgres    false    206    4            �           0    0    budgets_budgetid_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.budgets_budgetid_seq OWNED BY public.budgets.budgetid;
          public          postgres    false    205            �            1259    16561 
   categories    TABLE     �   CREATE TABLE public.categories (
    categoryid integer NOT NULL,
    username character varying,
    categoryname character varying,
    categorybudget integer DEFAULT 0,
    categorycolor character varying
);
    DROP TABLE public.categories;
       public            postgres    false    4            �            1259    16559    categories_categoryid_seq    SEQUENCE     �   CREATE SEQUENCE public.categories_categoryid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.categories_categoryid_seq;
       public          postgres    false    200    4            �           0    0    categories_categoryid_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.categories_categoryid_seq OWNED BY public.categories.categoryid;
          public          postgres    false    199            �            1259    16720    colors    TABLE     �   CREATE TABLE public.colors (
    colorid integer NOT NULL,
    colorname character varying,
    colorhex character varying,
    colortaken boolean,
    username character varying
);
    DROP TABLE public.colors;
       public            postgres    false    4            �            1259    16718    colors_colorid_seq    SEQUENCE     �   CREATE SEQUENCE public.colors_colorid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.colors_colorid_seq;
       public          postgres    false    4    208            �           0    0    colors_colorid_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.colors_colorid_seq OWNED BY public.colors.colorid;
          public          postgres    false    207            �            1259    16585    expenses    TABLE     �   CREATE TABLE public.expenses (
    expenseid integer NOT NULL,
    budgetid integer NOT NULL,
    expensename character varying NOT NULL,
    expenseamount numeric NOT NULL,
    expensedate date NOT NULL,
    username character varying
);
    DROP TABLE public.expenses;
       public            postgres    false    4            �            1259    16583    expenses_expenseid_seq    SEQUENCE     �   CREATE SEQUENCE public.expenses_expenseid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.expenses_expenseid_seq;
       public          postgres    false    4    202            �           0    0    expenses_expenseid_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.expenses_expenseid_seq OWNED BY public.expenses.expenseid;
          public          postgres    false    201            �            1259    16811    groupbudgets    TABLE     �   CREATE TABLE public.groupbudgets (
    budgetid integer NOT NULL,
    groupingid integer,
    budgetname character varying,
    budgetamount numeric,
    budgetcolor character varying,
    budgetdate date
);
     DROP TABLE public.groupbudgets;
       public            postgres    false    4            �            1259    16809    groupbudgets_id_seq    SEQUENCE     �   CREATE SEQUENCE public.groupbudgets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.groupbudgets_id_seq;
       public          postgres    false    214    4            �           0    0    groupbudgets_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.groupbudgets_id_seq OWNED BY public.groupbudgets.budgetid;
          public          postgres    false    213            �            1259    16820    groupcolors    TABLE     �   CREATE TABLE public.groupcolors (
    colorid integer DEFAULT nextval('public.colors_colorid_seq'::regclass) NOT NULL,
    colorname character varying,
    colorhex character varying,
    colortaken boolean,
    groupingid integer
);
    DROP TABLE public.groupcolors;
       public            postgres    false    207    4            �            1259    16830    groupexpenses    TABLE     �   CREATE TABLE public.groupexpenses (
    expenseid integer NOT NULL,
    budgetid integer,
    expensename character varying,
    expenseamount numeric,
    expensedate date,
    groupingid integer,
    username character varying
);
 !   DROP TABLE public.groupexpenses;
       public            postgres    false    4            �            1259    16828    groupexpenses_expenseid_seq    SEQUENCE     �   CREATE SEQUENCE public.groupexpenses_expenseid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.groupexpenses_expenseid_seq;
       public          postgres    false    4    217            �           0    0    groupexpenses_expenseid_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.groupexpenses_expenseid_seq OWNED BY public.groupexpenses.expenseid;
          public          postgres    false    216            �            1259    17019    groupnotifications    TABLE     c  CREATE TABLE public.groupnotifications (
    id integer NOT NULL,
    notificationtitle character varying,
    notificationmessage character varying,
    notificationdate date,
    notificationtype character varying,
    notificationstatus character varying,
    groupingid integer,
    senderusername character varying,
    bolddata character varying
);
 &   DROP TABLE public.groupnotifications;
       public            postgres    false    4            �            1259    17017    groupnotifications_id_seq    SEQUENCE     �   CREATE SEQUENCE public.groupnotifications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.groupnotifications_id_seq;
       public          postgres    false    4    221            �           0    0    groupnotifications_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.groupnotifications_id_seq OWNED BY public.groupnotifications.id;
          public          postgres    false    220            �            1259    16841    groupreminders    TABLE       CREATE TABLE public.groupreminders (
    reminderid integer NOT NULL,
    budgetid integer,
    remindername character varying,
    reminderamount numeric,
    reminderdate date,
    reminderdone boolean,
    groupingid integer,
    username character varying
);
 "   DROP TABLE public.groupreminders;
       public            postgres    false    4            �            1259    16839    groupreminders_reminderid_seq    SEQUENCE     �   CREATE SEQUENCE public.groupreminders_reminderid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.groupreminders_reminderid_seq;
       public          postgres    false    4    219            �           0    0    groupreminders_reminderid_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.groupreminders_reminderid_seq OWNED BY public.groupreminders.reminderid;
          public          postgres    false    218            �            1259    16758    groups    TABLE     U  CREATE TABLE public.groups (
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
    DROP TABLE public.groups;
       public            postgres    false    4            �            1259    16756    groups_id_seq    SEQUENCE     �   CREATE SEQUENCE public.groups_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.groups_id_seq;
       public          postgres    false    210    4            �           0    0    groups_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.groups_id_seq OWNED BY public.groups.id;
          public          postgres    false    209            �            1259    16800    notifications    TABLE     �  CREATE TABLE public.notifications (
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
 !   DROP TABLE public.notifications;
       public            postgres    false    4            �           0    0    COLUMN notifications.groupingid    COMMENT     T   COMMENT ON COLUMN public.notifications.groupingid IS 'for invitation notification';
          public          postgres    false    212            �            1259    16798    notifications_id_seq    SEQUENCE     �   CREATE SEQUENCE public.notifications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.notifications_id_seq;
       public          postgres    false    212    4            �           0    0    notifications_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;
          public          postgres    false    211            �            1259    16632 	   reminders    TABLE     3  CREATE TABLE public.reminders (
    reminderid integer NOT NULL,
    budgetid integer NOT NULL,
    remindername character varying(255) NOT NULL,
    reminderamount numeric NOT NULL,
    reminderdate date NOT NULL,
    reminderdone boolean DEFAULT false NOT NULL,
    username character varying NOT NULL
);
    DROP TABLE public.reminders;
       public            postgres    false    4            �            1259    16630    reminder_reminderid_seq    SEQUENCE     �   CREATE SEQUENCE public.reminder_reminderid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.reminder_reminderid_seq;
       public          postgres    false    4    204            �           0    0    reminder_reminderid_seq    SEQUENCE OWNED BY     T   ALTER SEQUENCE public.reminder_reminderid_seq OWNED BY public.reminders.reminderid;
          public          postgres    false    203            �            1259    16486    users    TABLE     g  CREATE TABLE public.users (
    "userID" integer NOT NULL,
    email character varying(255) NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    income numeric DEFAULT 0,
    "budgetRecurrence" integer DEFAULT 1,
    "reminderSetting1" boolean DEFAULT true,
    "reminderSetting2" boolean DEFAULT false
);
    DROP TABLE public.users;
       public            postgres    false    4            �            1259    16484    users_userID_seq    SEQUENCE     �   CREATE SEQUENCE public."users_userID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public."users_userID_seq";
       public          postgres    false    4    198            �           0    0    users_userID_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public."users_userID_seq" OWNED BY public.users."userID";
          public          postgres    false    197            �
           2604    16693    budgets budgetid    DEFAULT     t   ALTER TABLE ONLY public.budgets ALTER COLUMN budgetid SET DEFAULT nextval('public.budgets_budgetid_seq'::regclass);
 ?   ALTER TABLE public.budgets ALTER COLUMN budgetid DROP DEFAULT;
       public          postgres    false    206    205    206            �
           2604    16564    categories categoryid    DEFAULT     ~   ALTER TABLE ONLY public.categories ALTER COLUMN categoryid SET DEFAULT nextval('public.categories_categoryid_seq'::regclass);
 D   ALTER TABLE public.categories ALTER COLUMN categoryid DROP DEFAULT;
       public          postgres    false    199    200    200            �
           2604    16723    colors colorid    DEFAULT     p   ALTER TABLE ONLY public.colors ALTER COLUMN colorid SET DEFAULT nextval('public.colors_colorid_seq'::regclass);
 =   ALTER TABLE public.colors ALTER COLUMN colorid DROP DEFAULT;
       public          postgres    false    207    208    208            �
           2604    16588    expenses expenseid    DEFAULT     x   ALTER TABLE ONLY public.expenses ALTER COLUMN expenseid SET DEFAULT nextval('public.expenses_expenseid_seq'::regclass);
 A   ALTER TABLE public.expenses ALTER COLUMN expenseid DROP DEFAULT;
       public          postgres    false    201    202    202            �
           2604    16814    groupbudgets budgetid    DEFAULT     x   ALTER TABLE ONLY public.groupbudgets ALTER COLUMN budgetid SET DEFAULT nextval('public.groupbudgets_id_seq'::regclass);
 D   ALTER TABLE public.groupbudgets ALTER COLUMN budgetid DROP DEFAULT;
       public          postgres    false    214    213    214            �
           2604    16833    groupexpenses expenseid    DEFAULT     �   ALTER TABLE ONLY public.groupexpenses ALTER COLUMN expenseid SET DEFAULT nextval('public.groupexpenses_expenseid_seq'::regclass);
 F   ALTER TABLE public.groupexpenses ALTER COLUMN expenseid DROP DEFAULT;
       public          postgres    false    217    216    217            �
           2604    17022    groupnotifications id    DEFAULT     ~   ALTER TABLE ONLY public.groupnotifications ALTER COLUMN id SET DEFAULT nextval('public.groupnotifications_id_seq'::regclass);
 D   ALTER TABLE public.groupnotifications ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    221    220    221            �
           2604    16844    groupreminders reminderid    DEFAULT     �   ALTER TABLE ONLY public.groupreminders ALTER COLUMN reminderid SET DEFAULT nextval('public.groupreminders_reminderid_seq'::regclass);
 H   ALTER TABLE public.groupreminders ALTER COLUMN reminderid DROP DEFAULT;
       public          postgres    false    219    218    219            �
           2604    16761 	   groups id    DEFAULT     f   ALTER TABLE ONLY public.groups ALTER COLUMN id SET DEFAULT nextval('public.groups_id_seq'::regclass);
 8   ALTER TABLE public.groups ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    209    210    210            �
           2604    16803    notifications id    DEFAULT     t   ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);
 ?   ALTER TABLE public.notifications ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    212    211    212            �
           2604    16635    reminders reminderid    DEFAULT     {   ALTER TABLE ONLY public.reminders ALTER COLUMN reminderid SET DEFAULT nextval('public.reminder_reminderid_seq'::regclass);
 C   ALTER TABLE public.reminders ALTER COLUMN reminderid DROP DEFAULT;
       public          postgres    false    203    204    204            �
           2604    16489    users userID    DEFAULT     p   ALTER TABLE ONLY public.users ALTER COLUMN "userID" SET DEFAULT nextval('public."users_userID_seq"'::regclass);
 =   ALTER TABLE public.users ALTER COLUMN "userID" DROP DEFAULT;
       public          postgres    false    197    198    198            �          0    16690    budgets 
   TABLE DATA           h   COPY public.budgets (budgetid, username, budgetname, budgetamount, budgetcolor, budgetdate) FROM stdin;
    public          postgres    false    206   �o       {          0    16561 
   categories 
   TABLE DATA           g   COPY public.categories (categoryid, username, categoryname, categorybudget, categorycolor) FROM stdin;
    public          postgres    false    200   ;q       �          0    16720    colors 
   TABLE DATA           T   COPY public.colors (colorid, colorname, colorhex, colortaken, username) FROM stdin;
    public          postgres    false    208   Xq       }          0    16585    expenses 
   TABLE DATA           j   COPY public.expenses (expenseid, budgetid, expensename, expenseamount, expensedate, username) FROM stdin;
    public          postgres    false    202   �r       �          0    16811    groupbudgets 
   TABLE DATA           o   COPY public.groupbudgets (budgetid, groupingid, budgetname, budgetamount, budgetcolor, budgetdate) FROM stdin;
    public          postgres    false    214   �w       �          0    16820    groupcolors 
   TABLE DATA           [   COPY public.groupcolors (colorid, colorname, colorhex, colortaken, groupingid) FROM stdin;
    public          postgres    false    215   #x       �          0    16830    groupexpenses 
   TABLE DATA           {   COPY public.groupexpenses (expenseid, budgetid, expensename, expenseamount, expensedate, groupingid, username) FROM stdin;
    public          postgres    false    217   �}       �          0    17019    groupnotifications 
   TABLE DATA           �   COPY public.groupnotifications (id, notificationtitle, notificationmessage, notificationdate, notificationtype, notificationstatus, groupingid, senderusername, bolddata) FROM stdin;
    public          postgres    false    221   �~       �          0    16841    groupreminders 
   TABLE DATA           �   COPY public.groupreminders (reminderid, budgetid, remindername, reminderamount, reminderdate, reminderdone, groupingid, username) FROM stdin;
    public          postgres    false    219   ~       �          0    16758    groups 
   TABLE DATA           �   COPY public.groups (id, groupingid, adminusername, groupname, groupicon, memberusername, maxbudget, remindersetting1, remindersetting2) FROM stdin;
    public          postgres    false    210   �       �          0    16800    notifications 
   TABLE DATA           �   COPY public.notifications (id, notificationtitle, notificationmessage, notificationdate, notificationtype, notificationstatus, recipientusername, senderusername, bolddata, groupingid) FROM stdin;
    public          postgres    false    212   ��                 0    16632 	   reminders 
   TABLE DATA           }   COPY public.reminders (reminderid, budgetid, remindername, reminderamount, reminderdate, reminderdone, username) FROM stdin;
    public          postgres    false    204   �       y          0    16486    users 
   TABLE DATA           �   COPY public.users ("userID", email, username, password, income, "budgetRecurrence", "reminderSetting1", "reminderSetting2") FROM stdin;
    public          postgres    false    198   Ђ       �           0    0    budgets_budgetid_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.budgets_budgetid_seq', 93, true);
          public          postgres    false    205            �           0    0    categories_categoryid_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.categories_categoryid_seq', 98, true);
          public          postgres    false    199            �           0    0    colors_colorid_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.colors_colorid_seq', 650, true);
          public          postgres    false    207            �           0    0    expenses_expenseid_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.expenses_expenseid_seq', 257, true);
          public          postgres    false    201            �           0    0    groupbudgets_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.groupbudgets_id_seq', 12, true);
          public          postgres    false    213            �           0    0    groupexpenses_expenseid_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.groupexpenses_expenseid_seq', 93, true);
          public          postgres    false    216            �           0    0    groupnotifications_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.groupnotifications_id_seq', 13, true);
          public          postgres    false    220            �           0    0    groupreminders_reminderid_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.groupreminders_reminderid_seq', 7, true);
          public          postgres    false    218            �           0    0    groups_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.groups_id_seq', 100, true);
          public          postgres    false    209            �           0    0    notifications_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.notifications_id_seq', 117, true);
          public          postgres    false    211            �           0    0    reminder_reminderid_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.reminder_reminderid_seq', 79, true);
          public          postgres    false    203            �           0    0    users_userID_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public."users_userID_seq"', 57, true);
          public          postgres    false    197            �
           2606    16695    budgets budgets_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.budgets
    ADD CONSTRAINT budgets_pkey PRIMARY KEY (budgetid);
 >   ALTER TABLE ONLY public.budgets DROP CONSTRAINT budgets_pkey;
       public            postgres    false    206            �
           2606    16569    categories categories_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (categoryid);
 D   ALTER TABLE ONLY public.categories DROP CONSTRAINT categories_pkey;
       public            postgres    false    200            �
           2606    16728    colors colors_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY public.colors
    ADD CONSTRAINT colors_pkey PRIMARY KEY (colorid);
 <   ALTER TABLE ONLY public.colors DROP CONSTRAINT colors_pkey;
       public            postgres    false    208            �
           2606    16590    expenses expenses_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_pkey PRIMARY KEY (expenseid);
 @   ALTER TABLE ONLY public.expenses DROP CONSTRAINT expenses_pkey;
       public            postgres    false    202            �
           2606    16819    groupbudgets groupbudgets_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.groupbudgets
    ADD CONSTRAINT groupbudgets_pkey PRIMARY KEY (budgetid);
 H   ALTER TABLE ONLY public.groupbudgets DROP CONSTRAINT groupbudgets_pkey;
       public            postgres    false    214            �
           2606    16838     groupexpenses groupexpenses_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY public.groupexpenses
    ADD CONSTRAINT groupexpenses_pkey PRIMARY KEY (expenseid);
 J   ALTER TABLE ONLY public.groupexpenses DROP CONSTRAINT groupexpenses_pkey;
       public            postgres    false    217            �
           2606    17027 *   groupnotifications groupnotifications_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.groupnotifications
    ADD CONSTRAINT groupnotifications_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.groupnotifications DROP CONSTRAINT groupnotifications_pkey;
       public            postgres    false    221            �
           2606    16849 "   groupreminders groupreminders_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.groupreminders
    ADD CONSTRAINT groupreminders_pkey PRIMARY KEY (reminderid);
 L   ALTER TABLE ONLY public.groupreminders DROP CONSTRAINT groupreminders_pkey;
       public            postgres    false    219            �
           2606    16766    groups groups_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.groups DROP CONSTRAINT groups_pkey;
       public            postgres    false    210            �
           2606    16808     notifications notifications_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.notifications DROP CONSTRAINT notifications_pkey;
       public            postgres    false    212            �
           2606    16637    reminders reminder_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.reminders
    ADD CONSTRAINT reminder_pkey PRIMARY KEY (reminderid);
 A   ALTER TABLE ONLY public.reminders DROP CONSTRAINT reminder_pkey;
       public            postgres    false    204            �
           2606    16494    users users_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY ("userID");
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    198            �   a  x���Mo� ��3|/-����v܅�Lkkhu�ۏ�tR5+$^4�<��A��^L�^ڮ�(�RT_�/�rJ(�,+@o�X#F������u�	,5��j�Z;�
l{�K���ah��y��8��cX�>�������;���,���4"����;�n艳ws�D;gj;���w���;�>�f~�|���p:��qh�&��UXU�i��zv@,�O�\2;�ܘ�ˬ>`3�k�$�*#&H�P��\E�1��TL`<3&h�3�B,'�'}�*��	e�Ы��N��+2���cs�l]y���i�7Y��U����X��48�8]�4g%7^<=I��$alN�2<����8�      {      x������ � �      �   Y  x�}�˒� Eם�p�)�0��̦�C���T�~(m�Z��4}(�����쇫��h������&�{�>B�
[�����8��8SS�w`0��c�J��x��� -����j��	��{)ӽ���'F;�}l��J��
�XW�u}:�N�]�`P�X�o��ՌhA��a�jmѼ n��vp8O��џbO�5q��GH9E�2F�Pq8�s���Հ)W�ꃽ]b	'4�Lh��x���B\M9/4QV��[�E�>��Aoc�P�������bk-�V�R���a���:1̱�SB(SBy��r^	AV	���y%Y%����ﯢ(�Ny��      }   �  x��Vˎ�6<s����v!R���,�,�9�BK�̌$*|8���tӦlj4H��VuuU���IQ���N��'��f*=�?f�k?0��D������%�F8:�q��i���^��"�vrv���Ĳ����hj�3@Ct���GtM��(:�j��,#�!�
D�rT�TI��b���D��(8�m>���eF
N�~\�N�Y�~�^I���Ͱ�N�VvN:/aٮR%G"(�u�(�5	���%����b�MǕE���+&�r����p�yI{�,=@��S���Bm��I�R�8
߁�@���3սқ���S����I�XRuE����Gt��V��OoT�w=Ue�����6q6C���oK5ǱԤ�xC��h`D�� 1vsl5J�cOa���E?x	�]+V
��J��,J$�ƀn������ ���K=�?����:�U*�G�tT���CKxDY+7kb��e�m9cD�H��ģN5CG�Y�@Ħi��(j�'����.	K��E�a�E� �vFXd�Q�Ǥ��=����n�U_��I錠�fA����UPo�1�e�V`�՝Rh4�!�i��*D����'ք-�ǯ%���Z,��Yv�Wb�w�Rð�˂$U�a�7!!���`�D����	Y���sڐ�c�v�MC`1ݑ/^@�W��Fo
ޏ���R˰�$Ka��-'���-�3�-�m�~����t0�����_�~�v�q!o��|��2���N�WjOzY�<�����8k	��Y�̨䭵+�j
��'� ��2$O�yD����Aү x<���V���v��/�&��c�_�9p����2�yk�0O�r������V�*(	,�'�+x:X��Q�S����:��w`��,��%#�Y�â�^�Y��E��\P����ӺmD�r�Y��ݣ`���ľ�^�!�Y�� '��"��+[z '�(�er�j7��p9R}4R��uq笮�������m�	>�3��N.n�+.:*�P�/F�At/��I[�-)��u*�/߾~Z߆Wl�`� �o~�N�rq?�j�H��A������ ���o˹�H�6x�X׈����F����e�l�"$��=J����,xA����znL r۩|S��4�uW֣�0t�^$1�:gL<Z�T�`�Î5W������<�߱����D�f���|\�      �   r   x�}�1�0�پ�ѷU]Y:�]D"jZPCo߈&�'����c&*�\�~���ɠwQ(7E=�<�|&�w���ڧ���� (�ƪW����g��;��U��}��W��Y�0      �   �  x�}��nGD����Z��ݷ��/ٌH*,с,'�ߧ�"����:~^,Tχy�o�<��߾_?Χ��.�e�^�y7������G�_�S�������<=�^N��a������P���v��1���o��o?�//�p\_n�M�|�����9�V��,�/��q>���[v����_�?f)�v:��:�m��/��G�-�!N�X�����������˶n�x%��������{���s�������'�E���t��^���@�t�.�<�-
�'��B"����2i��vP���@�v줕'i�IZ������ʼ����zi��tt줕'i�IZ������ʼ���� ������w�p��tХ�\:��A�nx�6�n ݜts��I7#�P�����Xz��I/NzA酤#���B��}O����{Z������
�g�O��i����i��_z�K��ҫ��^�ҫ��^���.]F�D�K���MF�K�8�H��������ҳ�����3I�FzF除�(=jd� ��B'�L��S#S�Ҿ�u �Ld,���FV\#+��
5�bY�FV��lde��
4��Yq��`#+�ȊidY�FV���Q#k;i�IZa�V�E�����2/-b�;�F&2�^:v�ʓ��$��K�Xi�{ie^Z�Jw �Ld }��Ȕ'i�IZ������ʼ���� ��@z��I+O�
��B/-b�yi+�42��\�Թ݋�`�4/FJa2�H��j$�g��]�jvE#��s�/���f}��/��E��B����@I�����s�/���f}��/��E��B����@]���~���d}�Y_)�y}����~'Pܮh�_;��Y_i�W
�B^_$�+}!��	T�+�G�V_ �+��JA_��$}��/��;�2wE��^a_�n_�n_���U�ת��*�k�����Z�k����������Z�}��}��Vi_����Q��\l:i(6"$���2��Ŧ(6"ci��������*NM���j���SS��)pj���05����MM�SS��fj
�������)F%�t���"W��,����;X��������������/��_�ǿ�ǿ�ǿ0���A���1����pSS��)pj
���LM�SS��85Ũ���Ķ��ҹ�(�K��"`.�D�.�Dd,mˉr'�ˉB���D�HC9!i('"���PN�p�$����0�$�����r���&vjR�.��&�xi?5	�K��$B�����q9	('��I�rXN��I�rXN��I�r�F�$:��y��D������[*'�h3o��t �Dd��7[N��ͼ�r��6��ˉ@��������m9Q�.�ˉB��/'��PND��PNDƗ��D��t.'
�Ҿ��KC9�KC9��4[N��ב�ˉBzi���ב�D^G��e��������Y      �   �   x�u�A�0���\ 2����ĕ'pSp$hC�E9��DH�����a��$�~�l�3D $L�R��me*(�{9�&�u�j2�������uգ����ʔq��:!�K�,d�k����ۤ靃|U��2��=�0�K��@����8<?Pn�a��Ь���9SJ}�H�      �   �   x�����0D׽_��P^�M0����M��G�@�^�H���,�ΜN��btp]��
&D,L?c�ђ$��}c:։<�8$�ֱ��$JX��ƌ��冔ڃ%(3�vS��j��rv�u���.�\�63�����И�B�ufE0�\����a7��N��?�k�7�~����;�>��1u�F K+j6FjnK����X�,um;+hLP^�w�}��]�:�      �   U   x�3�44�t*�T(Ȭ�J,�45�30�4202�50�52�L�4�L-K��2�44���/.I�Q(J�+I��4BSmV��������� $��      �   �   x����� ���O��PDz�V�!�!;&��Ĺ���p![�ƺb�����0
k(*��ӡ�$I�1ؙT�6�]��jj��$y꛻��!�AeA����Q8llxP
W{�v�U��B�>�br"skE����K���J�EN�>|���셞�0Ԇ��r#��}׉p�.��~+��~�GZ�S���n6���t��*�$������      �   ?  x����N� ���)x�)�u]M�D�z�^z�Zb�,-6��K����檗���9�� ��8�'H+�VB��\}l/�DIw-Z-�U�y]��b�'�N�></�^@��	��($xd)4�B�}�ۈL0�X�<�W(��F&��h��0��p±9kf.��<6f�򪏡�:��V7���D�,�W6����:��5��2�s��,��F�:M؏覬�-�3'��˥���b�/����#Ù���5&ӑ�b��,
����Cz�\r��#��ԕ�n
�����N����f0�w��jy���NnCz��~�q�         �   x�u�=�@D�_q�dY>V[+-m<��&���D0�o�d�c��]/3�B��>"zH^��K�r-xI��:]�VWN���� }W��8zyW����ʋ)�39�S��7�nZ�<�i�����>��&m�ټ5�3uD�)䩂?�c*3S���?��d�	M��|!�C(Q      y   k   x�U��
� E�׏���hׇ�ĬH����z,ϝsFW0�=���H���PE	�Ah���}�H����z�H����|�$LNK$��|����4qK��o�K!�bk6�     