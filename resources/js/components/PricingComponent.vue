<template>

<section class="my-5">
    <div class="container-fluid">
        <div class="container">
        <h3>Pricing</h3>
            <div class="row" >
                <div class="col-sm-4 mb-4 " v-for="plan in items" :key="plan.message">
                    <div class="card text-center py-3 px-2">
                        <h2>Hello</h2>
                        <div class="title">
                            {{plan.name}}
                        </div>
                    </div>
                </div>
              <!--
                <div class="col-sm-4 mb-4 ">
                    <div class="card text-center py-3 px-2">
                        <div class="title">
                            {% if plan.name == 'Free' %}
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            {% elif plan.name == 'Standard' %}
                            <i class="fa fa-plane" aria-hidden="true"></i>
                            {% else %}
                            <i class="fa fa-rocket" aria-hidden="true"></i>
                            {% endif %}
                            <h2>{{plan.name}}</h2>
                            <p class="plan-description">{{plan.Description}}</p>
                        </div>
                        <div class="price">
                            <h4><sup>
                                {% if plans.country == 'GB' %}£
                                    {% elif plans.country == 'US' %}$
                                    {% else %} <s>N</s>{% endif %}

                            </sup>{{plan.price}}</h4>
                        </div>
                        <div class="option">
                            <ul>
                                {% for features in plan.features %}
                                <li> <i class="fa fa-check" aria-hidden="true"></i> {{features}} </li>
                                {% endfor %}
                                <li> <i class="fa fa-check" aria-hidden="true"></i> Sales funnel access</li>
                                <li> <i class="fa fa-check" aria-hidden="true"></i>Performance analytics </li>

                                <li> <i class="fa fa-check" aria-hidden="true"></i> Customer Support </li>
                            </ul>
                        </div>
                        <a href="{% url 'loginpage' %}">Subscribe Now </a>
                    </div>
                </div>
            -->
            </div>
        </div>
    </div>
</section>

</template>


<script>
    export default {
        data() {
            return {
                text : '',
                items: [
                    { message: 'Foo' },
                    { message: 'Bar' }
                ],
                plans : [],
            }
        },

        created (){
            this.fetchPlans();
        },

        methods : {
            fetchPlans () {
                const url = '/api/getplans';
                fetch(url)
                .then((response)=>response.json())
                .then((response)=>{
                    this.plans = response
                })
            }

        }
    }
</script>
